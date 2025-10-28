
from playwright.sync_api import sync_playwright

def run(playwright):
    browser = playwright.chromium.launch()
    page = browser.new_page()

    # Go to the login page.
    page.goto("http://localhost:8000/login.php")
    page.screenshot(path="jules-scratch/verification/login_page.png")

    # Attempt to log in with invalid credentials.
    page.fill('input[name="username"]', 'invalid_user')
    page.fill('input[name="pwd"]', 'invalid_password')
    page.click('button[name="login"]')
    page.wait_for_selector('span.alert-danger')
    page.screenshot(path="jules-scratch/verification/login_error.png")

    # Log in with valid non-admin credentials.
    page.goto("http://localhost:8000/login.php")
    page.fill('input[name="username"]', 'NCO001')
    page.fill('input[name="pwd"]', 'password')
    page.click('button[name="login"]')
    page.wait_for_url("http://localhost:8000/officer/")
    page.screenshot(path="jules-scratch/verification/officer_dashboard.png")

    # Log in with valid admin credentials.
    page.goto("http://localhost:8000/login.php")
    page.fill('input[name="username"]', 'admin')
    page.fill('input[name="pwd"]', 'password')
    page.click('button[name="login"]')
    page.wait_for_url("http://localhost:8000/2fa.php")
    page.screenshot(path="jules-scratch/verification/2fa_page.png")

    browser.close()

with sync_playwright() as playwright:
    run(playwright)
