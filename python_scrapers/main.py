import argparse
import json
import sys
import os
import time
import random
from scrapling.fetchers import StealthyFetcher
try:
    from scrapling.core._types import ProxyRotator
except ImportError:
    ProxyRotator = None

def get_random_delay():
    return random.uniform(2.5, 5.5)

def scrape_indeed(proxy_rotator=None):
    """
    Scrape jobs from Indeed
    """
    url = "https://www.indeed.com/jobs?q=developer&l=Remote"
    try:
        # Use stealthy fetcher to bypass antibots
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        time.sleep(get_random_delay()) # Attendre le chargement JS potentiel
        jobs = []
        
        # Selectors améliorés pour la nouvelle structure Indeed
        job_cards = page.css('.job_seen_beacon, .tapItem, td.resultContent')
        for card in job_cards:
            title = card.css('h2.jobTitle span::text, h2.jobTitle a::text, .jobTitle::text').get()
            company = card.css('span[data-testid="company-name"]::text, span.companyName::text, .companyName::text').get()
            location = card.css('div[data-testid="text-location"]::text, div.companyLocation::text').get()
            link_elem = card.css('h2.jobTitle a, a.jcs-JobTitle')
            link = "https://www.indeed.com" + link_elem[0].attrib.get('href', '') if link_elem else url
            
            description = " ".join(card.css('div.jobMetaDataGroup li::text, div.job-snippet li::text').getall())
            
            if title:
                jobs.append({
                    "source": "indeed",
                    "title": title.strip(),
                    "company": company.strip() if company else "Unknown",
                    "url": link,
                    "description": description.strip() if description else "",
                    "tags": [],
                    "country": location.strip() if location else "Remote",
                    "contract_type": "full_time",
                })
        
        return jobs
    except Exception as e:
        print(json.dumps({"error": str(e)}), file=sys.stderr)
        return []

def scrape_linkedin(proxy_rotator=None):
    """
    Scrape jobs from LinkedIn
    """
    url = "https://www.linkedin.com/jobs/search/?keywords=developer&location=Remote"
    try:
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        time.sleep(get_random_delay())
        jobs = []
        
        job_cards = page.css('ul.jobs-search__results-list li, div.base-card')
        for card in job_cards:
            title = card.css('h3.base-search-card__title::text, span.sr-only::text, .base-search-card__title::text').get()
            company = card.css('h4.base-search-card__subtitle a::text, a.hidden-nested-link::text, .base-search-card__subtitle::text').get()
            location = card.css('span.job-search-card__location::text').get()
            link_elem = card.css('a.base-card__full-link')
            link = link_elem[0].attrib.get('href', url) if link_elem else url
            
            if title:
                jobs.append({
                    "source": "linkedin",
                    "title": title.strip(),
                    "company": company.strip() if company else "Unknown",
                    "url": link,
                    "description": "",
                    "tags": [],
                    "country": location.strip() if location else "Remote",
                    "contract_type": "full_time",
                })
                
        return jobs
    except Exception as e:
        print(json.dumps({"error": str(e)}), file=sys.stderr)
        return []

def scrape_wellfound(proxy_rotator=None):
    url = "https://wellfound.com/role/l/software-engineer"
    try:
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        time.sleep(get_random_delay())
        jobs = []
        job_cards = page.css('div[class*="styles_result__"], div[class*="styles_component__"]')
        for card in job_cards:
            title = card.css('h2::text').get()
            company = card.css('h2 a::text').get()
            link_elem = card.css('a[class*="styles_component__"]')
            link = link_elem[0].attrib.get('href', url) if link_elem else url
            if title:
                jobs.append({
                    "source": "wellfound",
                    "title": title.strip(),
                    "company": company.strip() if company else "Unknown",
                    "url": link,
                    "description": "",
                    "tags": [],
                    "country": "Remote",
                    "contract_type": "full_time",
                })
        return jobs
    except Exception as e:
        print(json.dumps({"error": str(e)}), file=sys.stderr)
        return []

def scrape_flexjobs(proxy_rotator=None):
    url = "https://www.flexjobs.com/search?search=developer&location=Remote"
    try:
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        time.sleep(get_random_delay())
        jobs = []
        job_cards = page.css('li.job')
        for card in job_cards:
            title = card.css('a.job-title::text').get()
            link_elem = card.css('a.job-title')
            link = "https://www.flexjobs.com" + link_elem[0].attrib.get('href', '') if link_elem else url
            description = card.css('div.job-description::text').get()
            if title:
                jobs.append({
                    "source": "flexjobs",
                    "title": title.strip(),
                    "company": "Hidden on FlexJobs",
                    "url": link,
                    "description": description.strip() if description else "",
                    "tags": [],
                    "country": "Remote",
                    "contract_type": "full_time",
                })
        return jobs
    except Exception as e:
        print(json.dumps({"error": str(e)}), file=sys.stderr)
        return []

def scrape_generic(source_name, url, css_card, css_title, css_company, css_link, css_desc, css_loc, proxy_rotator=None):
    try:
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        time.sleep(get_random_delay())
        jobs = []
        job_cards = page.css(css_card)
        for card in job_cards:
            title = card.css(css_title).get()
            company = card.css(css_company).get() if css_company else None
            link_elem = card.css(css_link) if css_link else None
            link = url
            if link_elem:
                href = link_elem[0].attrib.get('href', '')
                if href:
                    if href.startswith('/'):
                        # Convertir lien relatif en absolu grossièrement
                        from urllib.parse import urlparse
                        parsed_url = urlparse(url)
                        base = f"{parsed_url.scheme}://{parsed_url.netloc}"
                        link = base + href
                    else:
                        link = href
            
            description = card.css(css_desc).get() if css_desc else None
            location = card.css(css_loc).get() if css_loc else None
            
            if title:
                jobs.append({
                    "source": source_name,
                    "title": title.strip(),
                    "company": company.strip() if company else "Unknown",
                    "url": link,
                    "description": description.strip() if description else "",
                    "tags": [],
                    "country": location.strip() if location else "Remote",
                    "contract_type": "full_time",
                })
        return jobs
    except Exception as e:
        print(json.dumps({"error": str(e)}), file=sys.stderr)
        return []


def main():
    parser = argparse.ArgumentParser(description="Scrape jobs using Scrapling")
    parser.add_argument("--source", type=str, required=True, 
                        choices=["indeed", "linkedin", "facebook", "wellfound", "flexjobs", "missionfreelance", "404works", "jobbers", "freenest", "justremote"], 
                        help="The source to scrape")
    
    args = parser.parse_args()
    
    proxy_rotator = None
    proxies_env = os.environ.get("SCRAPING_PROXIES")
    if proxies_env:
        proxy_list = [p.strip() for p in proxies_env.split(',') if p.strip()]
        if proxy_list:
            if ProxyRotator:
                proxy_rotator = ProxyRotator(proxy_list)
            else:
                proxy_rotator = proxy_list
    
    jobs = []
    if args.source == "indeed":
        jobs = scrape_indeed(proxy_rotator)
    elif args.source == "linkedin":
        jobs = scrape_linkedin(proxy_rotator)
    elif args.source == "wellfound":
        jobs = scrape_wellfound(proxy_rotator)
    elif args.source == "flexjobs":
        jobs = scrape_flexjobs(proxy_rotator)
    elif args.source == "missionfreelance":
        jobs = scrape_generic("missionfreelance", "https://www.missionfreelance.net/missions", "div.mission-card", "h3::text", "span.company::text", "a::attr(href)", "p.desc::text", "span.loc::text", proxy_rotator)
    elif args.source == "404works":
        jobs = scrape_generic("404works", "https://www.404works.com/fr/projets-freelance", "div.project-item", "h2 a::text", None, "h2 a::attr(href)", "div.description::text", None, proxy_rotator)
    elif args.source == "jobbers":
        jobs = scrape_generic("jobbers", "https://jobbers.ma/jobs", "div.job-list", "h3::text", "div.company::text", "a.job-link::attr(href)", None, "div.location::text", proxy_rotator)
    elif args.source == "freenest":
        jobs = scrape_generic("freenest", "https://freenest.com/missions", "div.mission", "h2::text", None, "a::attr(href)", "p::text", None, proxy_rotator)
    elif args.source == "justremote":
        jobs = scrape_generic("justremote", "https://justremote.co/remote-developer-jobs", "div.job-item", "h3::text", "div.company::text", "a::attr(href)", None, "div.location::text", proxy_rotator)
    elif args.source == "facebook":
        jobs = []
        
    print(json.dumps(jobs))

if __name__ == "__main__":
    main()
