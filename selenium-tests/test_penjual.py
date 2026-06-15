from selenium.webdriver.common.by import By
from selenium.webdriver.support import expected_conditions as EC

from base_test import BaseTest
from config import PENJUAL_EMAIL, PENJUAL_PASSWORD


class TestPenjualCRUD(BaseTest):
    PRODUCT_NAME = "Produk Selenium CRUD"

    def setUp(self):
        super().setUp()
        self.login(PENJUAL_EMAIL, PENJUAL_PASSWORD)

    def test_01_crud_produk(self):
        self.open("/barang/create")
        self.driver.find_element(By.NAME, "nama_barang").send_keys(self.PRODUCT_NAME)
        self.driver.find_element(By.NAME, "harga").send_keys("15000")
        self.driver.find_element(By.NAME, "stok").send_keys("9")
        self.driver.find_element(By.NAME, "kategori").send_keys("Snack")
        self.driver.find_element(By.NAME, "deskripsi").send_keys("Dibuat oleh Selenium")
        self.driver.find_element(By.CSS_SELECTOR, "[data-testid='product-submit']").click()

        self.wait.until(EC.url_contains("/barang"))
        row = self.wait.until(EC.presence_of_element_located((By.XPATH, f"//tr[.//*[normalize-space()='{self.PRODUCT_NAME}']]")))
        row.find_element(By.LINK_TEXT, "Edit").click()

        name = self.wait.until(EC.visibility_of_element_located((By.ID, "nama_barang")))
        name.clear()
        name.send_keys(f"{self.PRODUCT_NAME} Update")
        self.driver.find_element(By.XPATH, "//button[normalize-space()='Update']").click()

        updated = f"{self.PRODUCT_NAME} Update"
        row = self.wait.until(EC.presence_of_element_located((By.XPATH, f"//tr[.//*[normalize-space()='{updated}']]")))
        row.find_element(By.XPATH, ".//button[normalize-space()='Hapus']").click()
        self.driver.switch_to.alert.accept()
        self.wait.until(EC.invisibility_of_element_located((By.XPATH, f"//tr[.//*[normalize-space()='{updated}']]")))
