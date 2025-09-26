# Product Data Requirements for Top Google Ranking, Google Merchant Center, and Meta Pixel

Success in e-commerce visibility across Google and Meta (Facebook/Instagram) relies on providing **complete, consistent, and high-quality product data**.

---

## 1. Product Details for Ranking Top on Google (SEO & Shopping)

To rank well in Google Shopping and organic search, your data must be highly relevant and trustworthy.

| Product Detail | Optimization Strategy |
| :--- | :--- |
| **Product Title** | **Crucial for relevance.** Put the most important keywords at the start. Recommended structure: **Brand + Product Type + Key Feature/Material + Color/Size**. Limit to 70 characters for best display. **Must match** the title on your landing page. |
| **Product Description**| Use up to the **5000 character limit** to include detailed features, benefits, use cases, and supporting keywords. Ensure it is well-formatted and easy to read. |
| **GTIN/MPN** | **GTIN (UPC, EAN, ISBN) is highly recommended** and often required. It helps Google understand exactly what you sell, boosting visibility. If no GTIN, provide the **MPN** and set `identifier_exists` to `no`. |
| **Google Product Category** | Select the **most specific category** from Google's official taxonomy. This is critical for matching your product to relevant searches. |
| **Images** | Use the highest resolution images possible (at least 800x800 px). The main image should have a **plain white background** and display the product clearly. Use **`additional_image_link`** for lifestyle photos, angles, and variants. |
| **Price & Availability** | **Must be 100% accurate and consistent** between your feed and your product landing page. Discrepancies lead to disapprovals and low trust signals. |
| **Product Variants** | Use the `item_group_id` to group variations (color, size, material) of the same product. Each variant needs its own unique `id` and specific attributes (e.g., `red` for color). |
| **Landing Page Quality**| The page must be **mobile-friendly, load quickly,** and have clear pricing, availability, and return policies. |

---

## 2. Mandatory Requirements for Google Merchant Center (GMC)

GMC acts as the gateway for your products to appear on Google. Non-compliance results in product and account suspension.

### A. Required Product Data Attributes

These attributes are the minimum needed for almost all products:

* **`id`**: Unique identifier (e.g., SKU).
* **`title`**: Product name.
* **`description`**: Product details.
* **`link`**: URL to the product page.
* **`image_link`**: URL to the main product image.
* **`price`**: Product price with currency.
* **`availability`**: Current stock status.
* **`brand`**: Manufacturer/brand name.
* **`shipping`**: Detailed shipping cost and service information.

### B. Mandatory Website and Policy Requirements

* **Secure Checkout:** Your checkout and payment pages must be secured with a valid **SSL certificate (HTTPS)**.
* **Accessible Contact Information:** Clearly display working contact information (phone number, email, and physical address) on your website.
* **Clear Policies:** You must have easily found and clear policies for **Shipping, Returns, and Refunds** that detail costs, timelines, and conditions.
* **Complete Business Information:** Your business name and address must be consistent across your website and Merchant Center account.

---

## 3. Product Details for Meta Pixel & Dynamic Ads

The Meta Pixel uses product details (parameters) to track conversions and power **Dynamic Ads**, which retarget users with products they viewed.

The key is ensuring the **Product ID** sent by the Pixel matches the ID in your Facebook/Meta Catalog.

### Standard Events and Required Product Parameters

| Standard Event | When it Fires | Required Data/Parameters to Pass to the Pixel |
| :--- | :--- | :--- |
| **`ViewContent`** | User views a product page. | `content_ids` (Product ID/SKU), `content_type` (`product`), `value` (Product Price), `currency` |
| **`AddToCart`** | User clicks 'Add to Cart'. | `content_ids`, `content_type`, `value` (Cart Total), `currency` |
| **`Purchase`** | User lands on the Thank You/Confirmation page. | **`content_ids`** (of all purchased items), **`contents`** (array of ID, quantity, price), **`value`** (Order Total), **`currency`**, `num_items` |

### Key Pixel Requirements

* **Consistent ID Mapping:** The `content_ids` (often the SKU) sent in the Pixel's event code **MUST EXACTLY MATCH** the `ID` column in your Facebook Product Catalog.
* **Catalog Quality:** Ensure your Facebook Catalog data (which can be synced from your GMC feed) is complete and accurate, especially for image, title, price, and availability.
* **Advanced Matching:** Enable this feature in your Pixel settings. It sends hashed customer data (like email) to improve the accuracy of matching website activity to Facebook/Instagram users.