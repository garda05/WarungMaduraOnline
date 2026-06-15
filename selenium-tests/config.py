import os

BASE_URL = os.getenv("WARUNG_BASE_URL", "http://127.0.0.1:8000")

PENJUAL_EMAIL = os.getenv("WARUNG_PENJUAL_EMAIL", "penjual@warung.test")
PENJUAL_PASSWORD = os.getenv("WARUNG_PENJUAL_PASSWORD", "password123")

PEMBELI_EMAIL = os.getenv("WARUNG_PEMBELI_EMAIL", "pembeli@warung.test")
PEMBELI_PASSWORD = os.getenv("WARUNG_PEMBELI_PASSWORD", "password123")

SEEDED_PRODUCT = "Kopi Madura Selenium"
