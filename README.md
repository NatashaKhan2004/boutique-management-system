# Boutique Management System

A dynamic, web-based e-commerce platform built to manage product inventory, shopping carts, checkout operations, and order tracking seamlessly.

---

## 🚀 How to Run the Project

1. Clone or download this project repository to your local system.
2. Open the project folder.
3. Launch `addproduct.html` or `home.html` in any modern web browser (Google Chrome, Edge, Firefox).
4. No additional backend server or database setup is required — all data is saved and fetched dynamically using browser **LocalStorage**.

---

## ✅ Features Completed So Far

* **Product Management (Day 3):**
  * Adding products via `addproduct.html` saves entries directly into `localStorage`.
  * Dynamic rendering of product cards on `products.html` with stock display and product deletion.
* **Shopping Cart & Inventory Sync (Day 4):**
  * `cart.html` dynamically loads selected cart items from `localStorage`.
  * Real-time calculation of subtotals and grand total.
  * Live quantity adjustments and item removal with automatic stock count restoration.
* **Checkout & Orders Tracking (Day 5):**
  * Form validation on checkout to capture customer delivery details.
  * Successful order placement saves complete order records, clears the active cart, and redirects to `orders.html`.
  * `orders.html` displays a dynamic table containing all saved order details, items, customer info, and order date.

---

## 🛠️ Weekly Log & Debugging Tracker

### Friday Log: What Broke & How It Was Fixed
* **Issue 1:** Form submissions were triggering alert popups instead of saving data persistently.  
  * **Fix:** Linked form fields to event listeners and mapped payload objects into `localStorage` using `JSON.stringify()`.
* **Issue 2:** Adding a second product was overwriting the existing product array in `localStorage`.  
  * **Fix:** Initialized empty arrays for missing keys and parsed existing stored arrays using `JSON.parse()` before pushing new data.
* **Issue 3:** Cart table rows remained hardcoded and failed to update price calculations dynamically.  
  * **Fix:** Wrote a dynamic `renderCart()` JavaScript function to calculate totals directly from array state.
* **Issue 4:** Removing items from the cart did not reflect on the main stock page.  
  * **Fix:** Synchronized `cart.html` actions with the `products` array in `localStorage` to restore inventory levels upon item removal.
* **Issue 5:** Panel UI cutoff made the `Application` tab hidden in Developer Tools during testing.  
  * **Fix:** Used the tab menu overflow button `>>` and expanded DevTools to inspect storage state directly.

---

