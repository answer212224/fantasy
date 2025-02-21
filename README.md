# Fantasy

## 簡介
**Fantasy** 是一個基於 Laravel 開發的體育數據分析與管理系統，支援即時數據更新、用戶管理、球員統計等功能，適用於運動相關的數據應用場景。

## 技術棧
- **後端框架**: Laravel 10
- **前端框架**: Vue.js 3 (可選)
- **資料庫**: MySQL / PostgreSQL
- **快取**: Redis
- **API 認證**: Laravel Sanctum / JWT
- **訊息佇列**: Laravel Queue

## 環境需求
- PHP 8.1 以上
- MySQL 8.0 以上
- Redis（可選，用於快取）
- Composer
- Node.js 16+（若使用 Vue.js 前端）

## 安裝與設定

### 1. Clone 專案
```sh
git clone https://github.com/answer212224/fantasy.git
cd fantasy
```

### 2. 安裝 Laravel 依賴
```sh
composer install
```

### 3. 設定環境變數
```sh
cp .env.example .env
php artisan key:generate
```
根據需求修改 `.env` 設定，如 `DB_CONNECTION`、`DB_HOST`、`DB_DATABASE` 等。

### 4. 設定資料庫
```sh
php artisan migrate --seed
```
這將建立資料庫結構並填充初始數據。

### 5. 啟動開發伺服器
```sh
php artisan serve
```
伺服器將運行於 `http://127.0.0.1:8000`。

## API 使用方式

### 1. 取得 JWT Token
**請求方式:** `POST /api/login`

**參數:**
- `email`: 使用者帳號
- `password`: 密碼

**回應:**
```json
{
    "access_token": "your_token_here",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### 2. 取得球員數據
**請求方式:** `GET /api/players`

**請求標頭:**
```sh
Authorization: Bearer your_token_here
```

**回應:**
```json
[
    {
        "id": 1,
        "name": "LeBron James",
        "team": "Lakers",
        "points": 27.5,
        "rebounds": 8.3,
        "assists": 7.2
    },
    ...
]
```

## 測試
執行 PHPUnit 測試：
```sh
php artisan test
```

## 部署
1. 設定 `.env` 並執行：
   ```sh
   php artisan config:cache
   php artisan migrate --force
   ```
2. 使用 `supervisor` 管理 Laravel Queue（若有使用）：
   ```sh
   php artisan queue:work
   ```
3. 部署至 Nginx / Apache，確保 `public/` 目錄作為 Web 入口。

## 貢獻方式
- 提交 PR 時請遵循 Laravel 代碼規範與最佳實踐。
- 任何錯誤或建議請提交 Issue。

## 授權
本專案基於 **MIT License** 發布。
