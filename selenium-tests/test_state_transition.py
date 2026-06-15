from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC

from base_test import BaseTest
from config import (
    PEMBELI_EMAIL,
    PEMBELI_PASSWORD,
    PENJUAL_EMAIL,
    PENJUAL_PASSWORD,
    SEEDED_PRODUCT,
)


class TestStateTransitionPesanan(BaseTest):
    def create_order(self):
        self.login(PEMBELI_EMAIL, PEMBELI_PASSWORD)
        card = self.wait.until(EC.presence_of_element_located((
            By.CSS_SELECTOR,
            f"[data-testid='product-card'][data-product-name='{SEEDED_PRODUCT}']",
        )))
        add_button = card.find_element(By.CSS_SELECTOR, "[data-testid='add-to-cart']")
        add_button.click()
        self.wait.until(EC.staleness_of(add_button))
        self.open("/keranjang")
        self.wait.until(EC.element_to_be_clickable((By.CSS_SELECTOR, "[data-testid='checkout-submit']"))).click()
        self.wait.until(EC.url_contains("/pesanan/"))
        code_text = self.driver.find_element(
            By.XPATH,
            "//p[contains(normalize-space(), 'Kode Pesanan:')]",
        ).text
        code = code_text.split(":", 1)[1].strip()
        return code

    def pay_order(self):
        self.driver.find_element(By.CSS_SELECTOR, "[data-testid='payment-submit']").click()
        self.wait.until(lambda driver: "sedang disiapkan" in driver.page_source.lower())

    def open_order_as_seller(self, code):
        self.logout()
        self.login(PENJUAL_EMAIL, PENJUAL_PASSWORD)
        self.open("/penjual/pesanan")
        order = self.wait.until(EC.presence_of_element_located((By.XPATH, f"//*[normalize-space()='{code}']/ancestor::div[contains(@class,'p-4')][1]")))
        order.find_element(By.LINK_TEXT, "Detail →").click()

    def test_01_keranjang_ke_menunggu_pembayaran(self):
        self.create_order()
        self.assertIn("menunggu pembayaran", self.driver.page_source.lower())

    def test_02_menunggu_pembayaran_ke_sedang_disiapkan(self):
        self.create_order()
        self.pay_order()
        self.assertIn("sedang disiapkan", self.driver.page_source.lower())

    def test_03_sedang_disiapkan_ke_sedang_dikirim(self):
        code = self.create_order()
        self.pay_order()
        self.open_order_as_seller(code)
        self.driver.find_element(By.XPATH, "//button[normalize-space()='Tandai Sedang Dikirim']").click()
        self.wait.until(lambda driver: "sedang dikirim" in driver.page_source.lower())
        self.assertIn("sedang dikirim", self.driver.page_source.lower())

    def test_04_sedang_dikirim_ke_selesai(self):
        code = self.create_order()
        self.pay_order()
        self.open_order_as_seller(code)
        self.driver.find_element(By.XPATH, "//button[normalize-space()='Tandai Sedang Dikirim']").click()
        self.wait.until(EC.element_to_be_clickable((By.XPATH, "//button[normalize-space()='Tandai Pesanan Selesai']"))).click()
        self.wait.until(lambda driver: "selesai" in driver.page_source.lower())
        self.assertIn("selesai", self.driver.page_source.lower())
