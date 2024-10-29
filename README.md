# Rese（リーズ）
飲食店を運営するグループ会社の飲食店予約サービスです。
一般ユーザー・店舗責任者・管理者と3種のアカウントが用意されています。
 - 一般ユーザー：予約や店舗のレビュー投稿などができます。
 - 店舗責任者用：店舗の作成や編集、お客様へのメール送信、予約管理などができます。
 - 管理者：店舗責任者アカウントの作成や編集などができます。

 <img width="1456" alt="スクリーンショット 2024-10-29 8 59 44" src="https://github.com/user-attachments/assets/63aa5f9d-3acd-4c34-8665-a8b132729c19">

 ## 作成した目的
 外部の飲食店予約サービスは手数料などの負担がある。
 そういったものを削減するために、自社で予約サービスを展開したいと考えたため。

 ## 機能一覧
 - 会員登録
 - ログイン機能
 - ログアウト機能
 - 一般ユーザーの情報取得
 - 一般ユーザーの飲食店お気に入り一覧取得
 - 一般ユーザーの飲食店予約情報取得
 - 飲食店一覧取得
 - 飲食店詳細取得
 - 飲食店お気に入り追加
 - 飲食店お気に入り削除
 - 飲食店予約情報追加
 - 飲食店予約情報編集
 - 飲食店予約情報削除
 - 飲食店検索機能（エリア・ジャンル・店名で検索）
 - 一般ユーザー評価投稿機能
 - 店舗の評価投稿一覧取得
 - メール認証機能
 - 店舗責任者：店舗追加
 - 店舗責任者：店舗編集
 - 店舗責任者：予約追加
 - 店舗責任者：予約編集
 - 店舗責任者：予約削除
 - 店舗責任者：予約者へのメール送信機能
 - 管理者：店舗責任者アカウントの追加
 - 管理者：店舗責任者アカウントのアカウントの編集
 - 予約当日の朝に予約情報のリマインダーを送信
 - 予約追加・編集の実行後、予約確認メールが自動送信される
 - 予約確認メールへQRコードを添付
 - Stripeを利用した決済機能

### その他
 - FormRequestを使用したバリデーションの実装
 - レスポンシブデザインの対応
 - 店舗追加・編集時に登録した店舗画像をストレージに保存

## 使用言語
 - PHP 7.4.9
 - Laravel 8.0
 - MySQL 8.0.26

## テーブル設計
<img width="634" alt="tables_01" src="https://github.com/user-attachments/assets/3ae78288-67b5-41ca-a73d-25714c19691e">

<img width="630" alt="tables_02" src="https://github.com/user-attachments/assets/2e202ed7-f8d9-4d1d-8098-33f89b688331">

<img width="626" alt="tables_03" src="https://github.com/user-attachments/assets/a9c2ac71-7b69-4538-8791-65ce5bb7b0f2">

## ER図
![er drawio](https://github.com/user-attachments/assets/5139c3b3-9ddb-44df-b494-6e80b991369a)

## 環境構築
1. リポジトリのクローン
```
git clone git@github.com:Neito5865/rese_reservation-app.git
docker-compose up -d --build
```
＊MySQLは、OSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

2. Dockerのビルド
```
cd contact-form app
docker-compose up -d --build
```

### Laravel環境構築
1. PHPコンテナへログイン
```
docker-compose exec php bash
```

2. パッケージのインストール
```
composer install
```

3. .env.exampleファイルから.envファイルを作成する
```
cp .env.example .env
```

4. 環境変数を変更する
.envファイルの11行目以降を以下のように編集する
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```
.envファイルの31行目以降を以下のように編集する
```
MAIL_MAILER=smtp
MAIL_HOST=mailhog
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS=from@example.com
MAIL_FROM_NAME="${APP_NAME}"
```
.envファイルに以下を追記する（Stripeアカウントを所有している場合のみ）
```
STRIPE_KEY=your_test_stripe_key
STRIPE_SECRET=your_test_stripe_secret_key
```
※Stripeアカウントを所有している場合は、ご自身のアカウントにて決済機能をお試しいただけます。
その場合「your_test_stripe_key」にはStripeテスト環境の公開キーを、
「your_test_stripe_secret_key」にはStripeテスト環境のシークレットキーを
記述してください。


5. キーを作成する
```
php artisan key:generate
```
6. マイグレーションの実行
```
php artisan migrate
```
7. シーディングの実行
エリアの取得
```
php artisan db:seed --class=AreaSeeder
```
ジャンルの取得
```
php artisan db:seed --class=GenreSeeder
```
店舗の取得
```
php artisan db:seed --class=ShopSeeder
```
ユーザー情報の取得
```
php artisan db:seed --class=UserSeeder
```

### URL
 - トップページ：http://localhost/

 - phpMyAdmin
http://localhost:8080

## その他
以下のユーザー情報でログイン可能です。
 - 一般ユーザー
メールアドレス：user1@example.com
パスワード：password

 - 店舗責任者
メールアドレス：shop1@example.com
パスワード：password

 - 管理者
メールアドレス：admin1@example.com
パスワード：password