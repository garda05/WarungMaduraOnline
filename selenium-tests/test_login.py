from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC

from base_test import BaseTest
from config import PEMBELI_EMAIL, PEMBELI_PASSWORD, PENJUAL_EMAIL, PENJUAL_PASSWORD


class TestLogin(BaseTest):
    def test_01_halaman_login_tampil(self):
        self.open("/login")
        self.assertIn("Warung Madura Online", self.driver.page_source)
        self.assertTrue(self.driver.find_element(By.ID, "email").is_displayed())

    def test_02_penjual_berhasil_login(self):
        self.login(PENJUAL_EMAIL, PENJUAL_PASSWORD)
        self.assertIn("PENJUAL", self.driver.page_source)
        self.assertIn("Kelola Produk", self.driver.page_source)

    def test_03_pembeli_berhasil_login(self):
        self.login(PEMBELI_EMAIL, PEMBELI_PASSWORD)
        self.assertIn("Keranjang", self.driver.page_source)
        self.assertNotIn("Kelola Produk", self.driver.page_source)

    def test_04_login_gagal_password_salah(self):
        self.open("/login")
        self.driver.find_element(By.ID, "email").send_keys(PEMBELI_EMAIL)
        self.driver.find_element(By.ID, "password").send_keys("password-salah")
        self.driver.find_element(By.CSS_SELECTOR, "[data-testid='login-submit']").click()
        self.wait.until(EC.url_contains("/login"))
        self.assertIn("credentials", self.driver.page_source.lower())

    def test_05_logout_berhasil(self):
        self.login(PEMBELI_EMAIL, PEMBELI_PASSWORD)
        self.logout()
        self.assertIn("Silakan login", self.driver.page_source)
