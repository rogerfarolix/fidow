import argparse
import json
import sys
import os
from scrapling.fetchers import StealthyFetcher
try:
    from scrapling.core._types import ProxyRotator
except ImportError:
    ProxyRotator = None

def scrape_indeed(proxy_rotator=None):
    """
    Scrape jobs from Indeed (Proof of concept)
    """
    url = "https://www.indeed.com/jobs?q=developer&l=Remote"
    try:
        # Use stealthy fetcher to bypass antibots
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        jobs = []
        
        # This selector might need to be adjusted based on Indeed's current layout
        job_cards = page.css('.job_seen_beacon')
        for card in job_cards:
            title = card.css('h2.jobTitle span::text').get()
            company = card.css('span[data-testid="company-name"]::text').get()
            location = card.css('div[data-testid="text-location"]::text').get()
            link_elem = card.css('h2.jobTitle a')
            link = "https://www.indeed.com" + link_elem[0].attrib.get('href', '') if link_elem else url
            
            # Extract description snippet
            description = " ".join(card.css('div.jobMetaDataGroup li::text').getall())
            
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
    Scrape jobs from LinkedIn (Proof of concept)
    """
    # LinkedIn jobs search URL (publicly accessible sometimes without login, but very heavily protected)
    url = "https://www.linkedin.com/jobs/search/?keywords=developer&location=Remote"
    try:
        page = StealthyFetcher.fetch(url, headless=True, proxy=proxy_rotator)
        jobs = []
        
        job_cards = page.css('ul.jobs-search__results-list li')
        for card in job_cards:
            title = card.css('h3.base-search-card__title::text').get()
            company = card.css('h4.base-search-card__subtitle a::text').get()
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

def main():
    parser = argparse.ArgumentParser(description="Scrape jobs using Scrapling")
    parser.add_argument("--source", type=str, required=True, choices=["indeed", "linkedin", "facebook"], help="The source to scrape")
    
    args = parser.parse_args()
    
    # Check for proxies in ENV
    proxy_rotator = None
    proxies_env = os.environ.get("SCRAPING_PROXIES")
    if proxies_env:
        # Expecting comma separated proxies: http://user:pass@ip:port,http://user:pass@ip2:port
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
    elif args.source == "facebook":
        # Placeholder for Facebook scraping logic
        jobs = []
        
    # Output JSON to stdout so PHP can parse it
    print(json.dumps(jobs))

if __name__ == "__main__":
    main()
