import os
import unittest
from pathlib import Path

from selenium import webdriver
from selenium.webdriver.chrome.service import Service
from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC
from selenium.webdriver.support.ui import WebDriverWait
from webdriver_manager.chrome import ChromeDriverManager

from config import BASE_URL


class BaseTest(unittest.TestCase):
    def setUp(self):
        self.driver = self.create_driver()
        self.wait = WebDriverWait(self.driver, 10)

    def create_driver(self):
        chrome_binary = self.find_browser_binary("WARUNG_CHROME_BINARY", [
            Path(os.environ.get("PROGRAMFILES", "")) / "Google/Chrome/Application/chrome.exe",
            Path(os.environ.get("PROGRAMFILES(X86)", "")) / "Google/Chrome/Application/chrome.exe",
            Path(os.environ.get("LOCALAPPDATA", "")) / "Google/Chrome/Application/chrome.exe",
        ])

        if chrome_binary:
            options = webdriver.ChromeOptions()
            options.binary_location = str(chrome_binary)
            self.configure_options(options)
            return webdriver.Chrome(
                service=Service(ChromeDriverManager().install()),
                options=options,
            )

        edge_binary = self.find_browser_binary("WARUNG_EDGE_BINARY", [
            Path(os.environ.get("PROGRAMFILES", "")) / "Microsoft/Edge/Application/msedge.exe",
            Path(os.environ.get("PROGRAMFILES(X86)", "")) / "Microsoft/Edge/Application/msedge.exe",
            Path(os.environ.get("LOCALAPPDATA", "")) / "Microsoft/Edge/Application/msedge.exe",
        ])

        if edge_binary:
            options = webdriver.EdgeOptions()
            options.binary_location = str(edge_binary)
            self.configure_options(options)
            return webdriver.Edge(options=options)

        self.fail(
            "Chrome atau Microsoft Edge tidak ditemukan. Install salah satu browser "
            "atau isi WARUNG_CHROME_BINARY/WARUNG_EDGE_BINARY."
        )

    @staticmethod
    def find_browser_binary(env_name, candidates):
        configured = os.getenv(env_name)
        if configured and Path(configured).is_file():
            return Path(configured)

        return next((path for path in candidates if path.is_file()), None)

    @staticmethod
    def configure_options(options):
        if os.getenv("SELENIUM_HEADLESS", "0") == "1":
            options.add_argument("--headless=new")
        options.add_argument("--window-size=1440,1000")
        options.add_argument("--disable-search-engine-choice-screen")

    def tearDown(self):
        self.driver.quit()

    def open(self, path):
        self.driver.get(f"{BASE_URL}{path}")

    def login(self, email, password):
        self.open("/login")
        self.wait.until(EC.visibility_of_element_located((By.ID, "email"))).send_keys(email)
        self.driver.find_element(By.ID, "password").send_keys(password)
        self.driver.find_element(By.CSS_SELECTOR, "[data-testid='login-submit']").click()
        self.wait.until(EC.url_contains("/dashboard"))

    def logout(self):
        self.wait.until(EC.element_to_be_clickable((By.XPATH, "//button[.//span[normalize-space()='Keluar']]"))).click()
        self.wait.until(lambda driver: "/dashboard" not in driver.current_url)
        self.open("/login")
        self.wait.until(EC.visibility_of_element_located((By.ID, "email")))
