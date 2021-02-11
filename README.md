# README

## このプロジェクトについて

技術習得のために、マッチングアプリを試しに作成してみる

## 開発環境

- PHP 7.4.13
- Laravel 6.20.0
- MySQL 5.7
- Ngin X 1.18

## 構築手順

### コンテナの起動

```
make build
```

```
make up
```

### Laravelのインストール

```
make create-project
```

serverディレクトリ配下のlaravelディレクトリにアプリのファイルが作成されるので、
その中身を非表示ファイルごと一階層上のディレクトリに移動させる

### MySQLとの接続を設定

- .envファイルを下記のように設定

```
DB_CONNECTION=mysql
DB_HOST=db（←コンテナ名）
DB_PORT=3306（←コンテナ側のポート番号）
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=password
```

- .envの5行目も下記のように設定

```
APP_URL=http://localhost:8000
```

### artisanコマンドの実行場所

```
make work
```


## 導入したライブラリ

```
composer require jenssegers/agent
```

## デプロイ先

- コマンド
```
git subtree push --prefix server/ heroku master
```

- Herokuに導入
```
heroku run composer require fzaninotto/faker
```

- 参考記事
> https://qiita.com/rope19181/items/07d556715a3a4f6191bd