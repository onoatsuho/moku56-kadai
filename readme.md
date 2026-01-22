# イラオイWiki - Docker環境セットアップ手順

## プロジェクト構造

```
illaoi-wiki/
├── docker-compose.yml
├── Dockerfile
├── init-db/
│   ├── 01-schema.sql
│   └── 02.data.sql
└── htdocs/           
    ├── index.php
    ├── config/
    │    └── database.php
    ├── includes/
    │    ├── footer.php
    │    └── header.php
    └── pages/
         ├── detail.php
         ├── forum.php
         └── matchup.php
```

## セットアップ手順

### 1. プロジェクトディレクトリ作成

```bash
mkdir illaoi-wiki
cd illaoi-wiki
```

### 2. 必要なファイルを配置

上記のファイルをすべて配置してください。

### 3. Docker環境を起動

```bash
# コンテナをビルド・起動
docker-compose up -d --build

# ログを確認（DBが起動するまで少し待つ）
docker-compose logs -f
```

### 4. データを投入

docker-compose upしたときに自動でテーブルが作成され、データが投入される
データを編集した場合はdocker-compose down -vでリセットして、もう一度docker-compose upしたときに反映される

### 5. 動作確認

ブラウザで http://localhost:8080 にアクセス



