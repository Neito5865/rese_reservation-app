# MyBestRese（マイベストリーズ）
飲食店を運営するグループ会社の飲食店予約サービスです。
一般ユーザー・店舗責任者・管理者と3種のアカウントが用意されています。
 - 一般ユーザー：予約や店舗のレビュー投稿などができます。
 - 店舗責任者用：店舗の作成や編集、お客様へのメール送信、予約管理などができます。
 - 管理者：店舗責任者アカウントの作成や編集などができます。

 <img width="1209" alt="Image" src="https://github.com/user-attachments/assets/b410ad17-4b6d-4377-a304-2f9b8bf7c3b0" />

 ## 作成した目的
 外部の飲食店予約サービスは手数料などの負担がある。
 そういったものを削減するために、自社で予約サービスを展開したいと考えたため。

 ## 機能一覧
 - 会員登録
 - ログイン/ログアウト機能
 - メール認証機能
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
 - レビュー投稿機能
 - 飲食店の評価投稿一覧取得
 - 店舗責任者：店舗追加
 - 店舗責任者：店舗編集
 - 店舗責任者：予約追加
 - 店舗責任者：予約編集
 - 店舗責任者：予約削除
 - 店舗責任者：予約者へのメール送信機能
 - 管理者：店舗責任者アカウントの追加
 - 管理者：店舗責任者アカウントの編集
 - 予約追加・編集の実行後、予約確認メールが自動送信される
 - 予約確認メールへQRコードを添付
 - Stripeを利用した決済機能

### その他
 - FormRequestを使用したバリデーションの実装
 - レスポンシブデザインの対応
 - 店舗追加・編集時に登録した店舗画像をストレージに保存

## 使用言語
 - PHP 7.4.9
 - Laravel 8.0.26
 - MySQL 8.0.26
 - nginx 1.21.1

## ER図
![er drawio](https://github.com/user-attachments/assets/5139c3b3-9ddb-44df-b494-6e80b991369a)

## 環境構築
### Dockerビルド
1. リポジトリのクローン
```
git clone git@github.com:Neito5865/rese_reservation-app.git
```
＊MySQLは、OSによって起動しない場合があるので、それぞれのPCに合わせてdocker-compose.ymlファイルを編集してください。

2. Dockerのビルド
 - Laravelプロジェクトディレクトリへ移動
```
cd rese_reservation-app
```
 - Dockerのビルドを実行
 ```
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
 - .envファイルを作成
```
cp .env.example .env
```

4. 環境変数を変更する
 - .envファイルの11行目以降を以下のように編集する
```
DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=laravel_db
DB_USERNAME=laravel_user
DB_PASSWORD=laravel_pass
```

5. キーを作成する
```
php artisan key:generate
```

6. マイグレーションの実行
```
php artisan migrate
```

7. シーディングの実行
```
php artisan db:seed
```

8. シンボリックリンクの作成
```
php artisan storage:link
```

## メール認証
MailHogというツールを使用しています。  
.envファイルの31行目以降を以下のように編集してください。
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
以下のURLへアクセスすることで、受信メールを確認できます。  
http://lochalhost:8025

## Stripeについて
本アプリでは、Stripeでの決済機能を実装しています。  
店舗をご利用の際に会計時に、利用店舗・支払い金額・カード情報を入力し、カード決済を実行できる想定です。

決済機能を使用する場合は、以下のリンクから会員登録をしてください。  
https://dashboard.stripe.com/register

また、StripeのAPIキーを.envファイルに以下のように設定してください。
```
STRIPE_KEY="パブリックキー"
STRIPE_SECRET="シークレットキー"
```
「パブリックキー」にはStripeテスト環境の公開キーを、「シークレットキー」にはStripeテスト環境のシークレットキーを記述してください。

## URL
 - トップページ：http://localhost/
 - phpMyAdmin：http://localhost:8080
 - MailHog：http://localhost:8025

## テストアカウント
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