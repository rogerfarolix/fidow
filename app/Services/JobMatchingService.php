<?php

namespace App\Services;

use App\Models\DigestSubscriber;
use App\Models\JobListing;
use Illuminate\Support\Collection;

/**
 * Calcule un score de pertinence entre une offre d'emploi et le profil d'un abonné.
 * Score maximal théorique : 100 points.
 */
class JobMatchingService
{
    // ─── Poids par critère ────────────────────────────────────────────────────
    private const WEIGHT_DOMAIN    = 40;
    private const WEIGHT_METIER    = 30;
    private const WEIGHT_COUNTRY   = 15;
    private const WEIGHT_CONTRACT  = 10;
    private const WEIGHT_SALARY    = 5;

    /**
     * Sélectionne les N meilleures offres pour un abonné.
     * Ne retourne QUE des offres jamais envoyées à cet abonné.
     *
     * @param  DigestSubscriber  $subscriber
     * @param  int               $limit        Nombre d'offres à retourner (défaut 20)
     * @return Collection<JobListing>
     */
    public function getTopJobsForSubscriber(DigestSubscriber $subscriber, int $limit = 20): Collection
    {
        // Récupérer les offres actives non encore envoyées
        $candidates = JobListing::active()
            ->notSentTo($subscriber->id)
            ->get();

        if ($candidates->isEmpty()) {
            return collect();
        }

        // Scorer chaque offre
        $scored = $candidates->map(function (JobListing $job) use ($subscriber) {
            return [
                'job'   => $job,
                'score' => $this->score($job, $subscriber),
            ];
        });

        // Trier par score décroissant, retourner les top N
        return $scored
            ->sortByDesc('score')
            ->take($limit)
            ->pluck('job');
    }

    /**
     * Calcule le score de pertinence d'une offre pour un abonné.
     */
    public function score(JobListing $job, DigestSubscriber $subscriber): int
    {
        $score = 0;
        $prefs = $subscriber->preferences_with_defaults;

        // ── 1. Match domaine ──────────────────────────────────────────────────
        if ($job->domain && $subscriber->domain) {
            if ($job->domain === $subscriber->domain) {
                $score += self::WEIGHT_DOMAIN;
            } elseif ($job->domain !== 'other') {
                $score += (int)(self::WEIGHT_DOMAIN * 0.3); // bonus partiel si au moins classifié
            }
        }

        // ── 2. Match métier (fulltext dans titre + tags) ───────────────────────
        $metierWords = $this->tokenize($subscriber->metier);
        $jobText     = strtolower($job->title . ' ' . implode(' ', $job->tags ?? []) . ' ' . $job->description);
        $matchCount  = 0;

        foreach ($metierWords as $word) {
            if (mb_strlen($word) >= 3 && str_contains($jobText, $word)) {
                $matchCount++;
            }
        }

        if ($matchCount > 0) {
            $ratio = min($matchCount / max(count($metierWords), 1), 1.0);
            $score += (int)(self::WEIGHT_METIER * $ratio);
        }

        // ── 3. Match pays / localisation ─────────────────────────────────────
        $prefPays = strtolower($prefs['pays'] ?? '');

        if (!empty($prefPays)) {
            $jobCountry = strtolower($job->country ?? '');
            if ($jobCountry === 'worldwide' || str_contains($jobCountry, 'world') || str_contains($jobCountry, 'remote')) {
                $score += self::WEIGHT_COUNTRY; // Worldwide = OK pour tout le monde
            } elseif (str_contains($jobCountry, $prefPays) || str_contains($prefPays, $jobCountry)) {
                $score += self::WEIGHT_COUNTRY;
            } else {
                $score += (int)(self::WEIGHT_COUNTRY * 0.3); // bonus partiel quand même
            }
        } else {
            $score += (int)(self::WEIGHT_COUNTRY * 0.7); // pas de préférence pays → bonus par défaut
        }

        // ── 4. Match type de contrat ──────────────────────────────────────────
        $prefContrat = $prefs['type_contrat'] ?? null;
        if (!$prefContrat || $job->contract_type === $prefContrat || !$job->contract_type) {
            $score += self::WEIGHT_CONTRACT;
        } elseif (
            ($prefContrat === 'freelance' && in_array($job->contract_type, ['contract', 'freelance'])) ||
            ($prefContrat === 'full_time' && $job->contract_type === 'full_time')
        ) {
            $score += self::WEIGHT_CONTRACT;
        }

        // ── 5. Match salaire ──────────────────────────────────────────────────
        $salMin = $prefs['salaire_min'] ?? null;
        if (!$salMin || !$job->salary_max || $job->salary_max >= $salMin) {
            $score += self::WEIGHT_SALARY;
        }

        return min($score, 100);
    }

    /**
     * Tokenise un texte en mots normalisés.
     */
    private function tokenize(string $text): array
    {
        $text  = strtolower($text);
        $words = preg_split('/[\s,\/\-_]+/', $text, -1, PREG_SPLIT_NO_EMPTY);
        return array_filter($words, fn($w) => mb_strlen($w) >= 3);
    }
}
