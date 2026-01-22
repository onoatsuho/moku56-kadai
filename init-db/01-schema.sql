-- ============================================
-- Wiki：テキストのみ版 - DB定義（DDL）
-- ============================================

-- 1. ユーザー（将来の編集用・任意）
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id VARCHAR(36) UNIQUE NOT NULL,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- 2. チャンピオンマスタ（アイコン列削除）
CREATE TABLE IF NOT EXISTS champ_data (
    id INT PRIMARY KEY AUTO_INCREMENT,
    champ_name VARCHAR(100) UNIQUE NOT NULL
);

-- 3. アイテム（アイコン列削除）
CREATE TABLE IF NOT EXISTS items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    item_name VARCHAR(100) UNIQUE NOT NULL
);

-- 4. ルーン（アイコン列削除）
CREATE TABLE IF NOT EXISTS runes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    rune_name VARCHAR(100) NOT NULL,
    rune_tree VARCHAR(50) NOT NULL
);

-- 5. ルーンページ（プリセット）
CREATE TABLE IF NOT EXISTS rune_pages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    description TEXT,
    keystone_rune_id INT NOT NULL,

    FOREIGN KEY (keystone_rune_id)
        REFERENCES runes(id)
);

-- 6. ルーンページ中身（多対多）
CREATE TABLE IF NOT EXISTS rune_page_entries (
    rune_page_id INT NOT NULL,
    rune_id INT NOT NULL,
    sort_order INT DEFAULT 0,

    PRIMARY KEY (rune_page_id, rune_id),

    FOREIGN KEY (rune_page_id)
        REFERENCES rune_pages(id)
        ON DELETE CASCADE,

    FOREIGN KEY (rune_id)
        REFERENCES runes(id)
        ON DELETE CASCADE
);

-- 7. 【メインページ用】対面サマリー
CREATE TABLE IF NOT EXISTS illaoi_matchup_summary (
    enemy_champ_id INT PRIMARY KEY,
    advantage CHAR(1) NOT NULL,
    first_item_id INT NOT NULL,
    rune_page_id INT NOT NULL,

    FOREIGN KEY (enemy_champ_id)
        REFERENCES champ_data(id),

    FOREIGN KEY (first_item_id)
        REFERENCES items(id),

    FOREIGN KEY (rune_page_id)
        REFERENCES rune_pages(id)
);

-- 8. 【詳細ページ用】マッチアップ本文
CREATE TABLE IF NOT EXISTS illaoi_matchup_detail (
    enemy_champ_id INT PRIMARY KEY,
    overview TEXT,
    early_game TEXT,
    mid_game TEXT,
    late_game TEXT,
    win_condition TEXT,
    lose_condition TEXT,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (enemy_champ_id)
        REFERENCES champ_data(id)
        ON DELETE CASCADE
);

-- 9. 【詳細ページ用】細かい対策・Tips
CREATE TABLE IF NOT EXISTS illaoi_matchup_tips (
    id INT PRIMARY KEY AUTO_INCREMENT,
    enemy_champ_id INT NOT NULL,
    title VARCHAR(255),
    content TEXT,
    sort_order INT DEFAULT 0,

    FOREIGN KEY (enemy_champ_id)
        REFERENCES champ_data(id)
        ON DELETE CASCADE
);

-- インデックス作成
CREATE INDEX idx_champ_name ON champ_data(champ_name);
CREATE INDEX idx_matchup_advantage ON illaoi_matchup_summary(advantage);
CREATE INDEX idx_tips_champ ON illaoi_matchup_tips(enemy_champ_id);