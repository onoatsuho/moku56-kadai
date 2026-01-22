FROM php:8.2-apache

# 必要なPHP拡張をインストール
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Apache mod_rewriteを有効化（URL書き換え用）
RUN a2enmod rewrite

# Apacheの設定を変更（.htaccessを有効化）
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# タイムゾーン設定（オプション）
RUN echo "date.timezone = Asia/Tokyo" > /usr/local/etc/php/conf.d/timezone.ini

# エラー表示設定（開発環境用）
RUN echo "display_errors = On" > /usr/local/etc/php/conf.d/errors.ini && \
    echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/errors.ini

# 作業ディレクトリ設定
WORKDIR /var/www/html

# 権限設定
RUN chown -R www-data:www-data /var/www/html

# ポート80を公開
EXPOSE 80