from selenium.webdriver.common.by import By

from base_test import BaseTest
from config import PEMBELI_EMAIL, PEMBELI_PASSWORD


class TestPembeliAkses(BaseTest):
    def setUp(self):
        super().setUp()
        self.login(PEMBELI_EMAIL, PEMBELI_PASSWORD)

    def test_01_menu_pembeli_tampil(self):
        self.assertIn("Keranjang", self.driver.page_source)
        self.assertIn("Pesanan", self.driver.page_source)

    def test_02_menu_kelola_produk_tidak_tampil(self):
        self.assertNotIn("Kelola Produk", self.driver.page_source)

    def test_03_tidak_bisa_akses_crud_penjual(self):
        self.open("/barang/create")
        self.assertIn("403", self.driver.page_source)

    def test_04_bisa_membuka_keranjang(self):
        self.open("/keranjang")
        self.assertTrue(self.driver.find_element(By.TAG_NAME, "body").is_displayed())
        self.assertIn("keranjang", self.driver.page_source.lower())
