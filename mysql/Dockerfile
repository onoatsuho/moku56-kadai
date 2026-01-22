FROM mysql:8.0

# 文字コード設定（UTF-8）
RUN echo "[mysqld]" > /etc/mysql/conf.d/charset.cnf && \
    echo "character-set-server=utf8mb4" >> /etc/mysql/conf.d/charset.cnf && \
    echo "collation-server=utf8mb4_unicode_ci" >> /etc/mysql/conf.d/charset.cnf && \
    echo "" >> /etc/mysql/conf.d/charset.cnf && \
    echo "[client]" >> /etc/mysql/conf.d/charset.cnf && \
    echo "default-character-set=utf8mb4" >> /etc/mysql/conf.d/charset.cnf

# タイムゾーン設定（オプション）
ENV TZ=Asia/Tokyo

# ポート3306を公開
EXPOSE 3306