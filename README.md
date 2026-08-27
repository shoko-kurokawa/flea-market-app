## フリマアプリ開発

## 概要

COACHTECH模擬案件としてフリマアプリを作成しました。

## 環境構築

### Dockerビルド

1. リポジトリをクローン
   git clone https://github.com/shoko-kurokawa/flea-market-app

2. プロジェクトディレクトリへ移動
3. Composerパッケージをインストール
   docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php85-composer:latest \
    composer install --ignore-platform-reqs
4. .env ファイルを作成
5. Dockerコンテナを起動

### Laravel環境構築

1. アプリケーションキーを作成
   ./vendor/bin/sail artisan key:generate
2. マイグレーション・シーディングを実行
   ./vendor/bin/sail artisan migrate:fresh --seed

## 使用技術

- PHP 8.5
- Laravel 12.x
- MySQL 8.4
- Laravel Fortify
- Laravel Sail
- Mailpit

## ER図

<img width="7937" height="6853" alt="Image" src="https://github.com/user-attachments/assets/bafe53ec-a668-4895-8c2e-533eabf68ac6" />

## 開発環境

- 商品一覧画面：http://localhost/
- 会員登録画面: http://localhost/register
- ログイン画面: http://localhost/login
- Mailpit：http://localhost:8025/

## 作成者

黒川尚子
