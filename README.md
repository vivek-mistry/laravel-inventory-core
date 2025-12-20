## 📦 Laravel Inventory Core

A Headless Stock & Inventory Engine for Laravel

A lightweight, extensible inventory management core for Laravel applications.
Built for e-commerce, POS, ERP, invoicing, and warehouse systems. \
⭐ No UI \
🧠 Logic-first \
⚡ Production-ready 

**🚀 Why Laravel Inventory Core?** \
Most inventory packages are: \
❌ UI-heavy \
❌ Hard to customize \
❌ Tied to specific schemas \

**Laravel Inventory Core is different.** \
✔ Works with any Eloquent model \
✔ Multi-warehouse ready \
✔ Prevents overselling \
✔ Event-driven & audit-safe \
✔ Clean API developers love

## ✨ Features
✅ Core Inventory
- Stock in / stock out 
- Stock adjustments 
- Available vs reserved stock 
- Negative stock protection 

🔒 Reservation System
- Cart & order reservations
- Overselling prevention
- Safe release mechanism

🏬 Warehouses
- Multiple warehouses / godowns
- Default warehouse support
- Warehouse-aware stock

🔁 Audit & Reliability
- Complete stock movement history
- Traceable inventory changes
- Accounting-friendly design

🚨 Low Stock Alerts
- Threshold-based alerts
- Event-driven notifications

## 📌 Ideal For
✔ Laravel e-commerce platforms \
✔ POS systems \
✔ ERP & internal tools \
✔ Invoice & billing systems \
✔ SaaS products needing inventory

## 🛠️ Installation

Install the package via Composer:
```bash
composer require vivek-mistry/laravel-inventory-core
```

Publish config (optional):
```bash
php artisan vendor:publish --tag=inventory-config
```

Run migrations:
```bash
php artisan migrate
```

## ⚙️ Configuration
`config/inventory.php`
```php
return [
    'default_warehouse' => null,
    'allow_negative_stock' => false,
    'low_stock_threshold' => 5,
];
```

## 🧱 Database Tables
| Table                  | Purpose                    |
| ---------------------- | -------------------------- |
| `inventory_stocks`     | Current stock per model    |
| `inventory_movements`  | Complete stock audit trail |
| `inventory_warehouses` | Multi-warehouse support    |

## 🧩 Making a Model Stockable
Use the `Stockable` trait on any Eloquent model.
```php
use VivekMistry\InventoryCore\Traits\Stockable;

class Product extends Model
{
    use Stockable;
}
```
That’s it 🎉


## 🧮 Basic Usage
Add Stock
```php
$product->addStock(100);
```
With warehouse
```php
$product->addStock(50, ['reason' => 'Initial stock'], warehouseId: 1);
```
➖ Reduce Stock
```php
$product->reduceStock(5);
```
🔒 Reserve Stock (Cart / Order)

Prevents overselling.
```php
$product->reserveStock(2);
```
With warehouse:
```php
$product->reserveStock(2, warehouseId: 1);
```
🔓 Release Reserved Stock
```php
$product->releaseStock(2);
```
📊 Stock Helpers
```php
$product->availableStock(); // quantity - reserved
$product->reservedStock();
```

🏬 Warehouses

Warehouses are optional but recommended.
```php
InventoryWarehouse::create([
    'name' => 'Main Warehouse',
    'code' => 'MAIN',
    'is_default' => true,
]);
```
If no warehouse is provided, the default warehouse is used.

🚨 Low Stock Detection
Triggered automatically when stock falls below threshold.
```php
'low_stock_threshold' => 5,
```

Listen to the event:
```php
use InventoryCore\Events\LowStockDetected;

Event::listen(LowStockDetected::class, function ($event) {
    // Send email, Slack, notification, etc.
});
```

```php
## 🧪 Example Flow (Real-World)
$product->addStock(100);
$product->reserveStock(10);   // Cart
$product->availableStock();   // 90
$product->releaseStock(5);    // Cart cancelled
$product->reduceStock(5);   
```

## 🧪 Testing
```php
vendor/bin/phpuit
```

## Change Logs
- Initial 2 Phases are released.

## Credits

- [Vivek Mistry](https://github.com/vivek-mistry) - Project creator and maintainer

## 🤝 Contributing
Pull requests are welcome. \
Ideas, issues, and improvements are encouraged.

**⭐ Support the Project**  \
If this package helps you: \
🌟 Star the repository \
🧠 Share with the Laravel community \
🐛 Report issues & suggestions

## License
MIT License. See [LICENSE](/vivek-mistry/laravel-invoice-engine/blob/main/LICENSE) for details.