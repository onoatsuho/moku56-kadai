-- ============================================
-- 初期データ（コンテナ起動時に自動実行される）
-- ============================================

-- チャンピオン
INSERT INTO champ_data (champ_name) VALUES 
('Mordekaiser'), 
('Jayce'), 
('Teemo');

-- アイテム
INSERT INTO items (item_name) VALUES 
('マルモティウスの胃袋'), 
('アイスボーンガントレット'), 
('ストライドブレイカー');

-- ルーン
INSERT INTO runes (rune_name, rune_tree) VALUES 
('征服者', '栄華'),
('冷静沈着', '栄華'),
('レジェンド:ヘイスト', '栄華'),
('背水の陣', '栄華'),
('キャッシュバック', '天啓'),
('宇宙の英知', '天啓');

-- ルーンページ
INSERT INTO rune_pages (name, description, keystone_rune_id) VALUES 
('征服者基本型', '基本固定', 1);

-- ルーンページ中身
INSERT INTO rune_page_entries (rune_page_id, rune_id, sort_order) VALUES 
(1, 1, 1), 
(1, 2, 2), 
(1, 3, 3), 
(1, 4, 4), 
(1, 5, 5), 
(1, 6, 6);

-- マッチアップサマリー
INSERT INTO illaoi_matchup_summary (enemy_champ_id, advantage, first_item_id, rune_page_id) VALUES 
(1, '△', 1, 1),
(2, '○', 2, 1),
(3, '△', 3, 1);

-- マッチアップ詳細
INSERT INTO illaoi_matchup_detail (enemy_champ_id, overview, early_game, mid_game, late_game, win_condition, lose_condition) VALUES 
(1, 
'ゲーム全体を通して不利なので慎重に立ち回りましょう。', 
'レベル6前まではEを当てて、反撃されそうなら下がってQでダメージトレードしましょう', 
'レベル6以降は普通に不利です。難しいですが相手のultに合わせてultして無効化しましょう。', 
'集団戦でultを使った後にultで隔離されると面倒です、気を遣いながらultしましょう。アイテムが相手より揃っていればultの中でも勝てます', 
'Eを当てて相手の反撃に付き合わないこと、イグゾーストやマルモティウスの胃袋で相手のultを耐えた後にultを使う', 
'レベル6前までに有利が取れず、相手がultを先に使わなくてもよい状況になれば厳しい。');

-- Tips
INSERT INTO illaoi_matchup_tips (enemy_champ_id, title, content, sort_order) VALUES 
(1, '相手のモーションを見よう', 'デフォルトスキンであれば、メイスを前に突き出したのを見て返そう', 1),
(1, '冥界内のult', '相手のultの中でも、Eとultが残っていたり、体力有利が大きい場合等、勝てそうならE→ultで倒してしまってもいい', 2);