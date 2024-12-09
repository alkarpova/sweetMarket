# Marketplace - SweetMarket
## Used technologies
- Laravel 11
- FilamentPHP
- TailwindCSS
- AlpineJS
- Livewire
- Laravel Socialite

## Description
The marketplace system is designed to connect sellers of baked goods and sweets with potential buyers. The platform includes the following core functionalities:
- User Registration and Authentication: Both sellers and buyers can register, log in, and manage their accounts. Sellers have access to product management features, while buyers can browse and purchase products.
- Product Listing: Sellers can create and manage product listings, including categories like cakes, cookies, vegan sweets, and more. Each product listing contains descriptions, images, prices, and information on dietary restrictions (e.g., gluten-free, vegan). 
- Shopping Cart and Checkout: Buyers can add products to a shopping cart, calculate taxes and shipping, and proceed through a secure checkout process with multiple payment options. 
- Order Management: Sellers can manage incoming orders, update order statuses, and communicate with buyers regarding shipment details. 
- Review and Rating System: Buyers can leave reviews and ratings for products they purchase, helping others make informed decisions. 
- Search and Filtering: The platform includes advanced search and filtering capabilities, allowing buyers to quickly find specific products based on category, dietary needs, or price. 
- Admin Dashboard: An admin panel allows the platform owner to oversee transactions, manage users, approve product listings, and resolve disputes.

## Models
### **User**
The user model represents a system user.
- `name`: user name
- `email`: unique email
- `password`: encrypted password

### **Country**
The country model represents countries.
- `name`: country name
- `has_vat`: VAT presence (true, false)
- `outside_eu_vat`: country outside the EU

### **Region**
The region model represents regions within a country.
- `name`: region name
- `country_id`: foreign key to the country model

### **City**
The city model represents cities within a region.
- `name`: city name
- `region_id`: foreign key to the region model
- `country_id`: foreign key to the country model
- `status`: city status

### **Allergen**
Allergens present in products.
- `name`: allergen name
- `description`: allergen description
- `severity_level`: allergen severity level

### **Theme**
Themes for the platform.
- `name`: theme name
- `status`: theme status

### **Ingredient**
Ingredients used in products.
- `name`: ingredient name
- `description`: ingredient description
- `is_allergen`: allergen flag
- `is_vegan`: vegan flag
- `is_organic`: organic flag

### **???Seller???**
Sellers registered on the platform.
- `name`: seller name
- `description`: seller description
- `user_id`: foreign key to the user model
- `country_id`: foreign key to the country model
- `region_id`: foreign key to the region model
- `address`: seller address
- `phone`: seller phone number
- `website`: seller website
- `vat_number`: VAT number

### **Category**
Product categories.
- `name`: category name
- `description`: category description
- `parent_id`: parent category ID
- `is_active`: active flag
- `is_featured`: featured flag
- `is_popular`: popular flag

### **Product**
Products available for sale.
- `name`: product name
- `description`: product description
- `price`: product price
- `category_id`: foreign key to the category model
- `seller_id`: foreign key to the user model
- `is_vegan`: vegan flag
- `is_gluten_free`: gluten-free flag
- `is_nut_free`: nut-free flag
- `is_organic`: organic flag
- `is_halal`: halal flag
- `is_kosher`: kosher flag
- `is_sugar_free`: sugar-free flag
- `is_lactose_free`: lactose-free flag

### **Shipping**
Shipping methods available for products.
- `name`: shipping method name
- `description`: shipping method description
- `price`: shipping method price
- `is_active`: active flag
- `is_default`: default flag
- `is_express`: express flag
- `is_international`: international flag
- `is_free`: free flag
- `is_pickup`: pickup flag
- `is_local`: local flag

### **Payment**
Payment methods available for orders.
- `name`: payment method name
- `description`: payment method description
- `is_active`: active flag
- `is_default`: default flag
- `is_cash`: cash flag
- `is_card`: card flag
- `is_paypal`: PayPal flag
- `is_stripe`: Stripe flag
- `is_bank_transfer`: bank transfer flag

### **Order**
Orders placed by buyers.
- `buyer_id`: foreign key to the user model
- `seller_id`: foreign key to the user model
- `product_id`: foreign key to the product model
- `quantity`: product quantity
- `total_price`: total order price
- `status`: order status
- `is_paid`: paid flag
- `is_shipped`: shipped flag
- `is_delivered`: delivered flag
- `is_cancelled`: cancelled flag
- `is_refunded`: refunded flag
- `is_disputed`: disputed flag
- `dispute_reason`: dispute reason
- `dispute_resolution`: dispute resolution
- `dispute_status`: dispute status
- `dispute_date`: dispute date
- `shipping_date`: shipping date
- `delivery_date`: delivery date
- `cancelled_date`: cancelled date
- `refunded_date`: refunded date

### **Review**
Product reviews left by buyers.
- `buyer_id`: foreign key to the user model
- `order_id`: foreign key to the order model
- `rating`: review rating
- `comment`: review comment
- `is_active`: active flag
- `is_approved`: approved flag

### **Complaint**
Complaints filed by buyers.
- `buyer_id`: foreign key to the user model
- `seller_id`: foreign key to the user model
- `order_id`: foreign key to the order model
- `reason`: complaint reason
- `resolution`: complaint resolution
- `status`: complaint status

###')
