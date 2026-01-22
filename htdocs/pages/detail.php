<?php
$database = new Database();
$db = $database->getConnection();

// 基本情報取得
$query = "
    SELECT
        c.id,
        c.champ_name,
        s.advantage,
        i.item_name AS first_item_name,
        d.overview,
        d.early_game,
        d.mid_game,
        d.late_game,
        d.win_condition,
        d.lose_condition
    FROM champ_data c
    LEFT JOIN illaoi_matchup_summary s ON c.id = s.enemy_champ_id
    LEFT JOIN items i ON i.id = s.first_item_id
    LEFT JOIN illaoi_matchup_detail d ON c.id = d.enemy_champ_id
    WHERE c.id = :champ_id
";

$stmt = $db->prepare($query);
$stmt->bindParam(':champ_id', $champ_id);
$stmt->execute();
$detail = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$detail) {
    echo "<div class='max-w-6xl mx-auto p-6'><div class='bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded'>チャンピオンが見つかりません</div></div>";
    return;
}

// ルーン情報取得
$rune_query = "
    SELECT
        r.rune_tree,
        r.rune_name
    FROM rune_page_entries rpe
    JOIN runes r ON r.id = rpe.rune_id
    JOIN illaoi_matchup_summary s ON s.rune_page_id = rpe.rune_page_id
    WHERE s.enemy_champ_id = :champ_id
    ORDER BY rpe.sort_order
";

$rune_stmt = $db->prepare($rune_query);
$rune_stmt->bindParam(':champ_id', $champ_id);
$rune_stmt->execute();
$runes = $rune_stmt->fetchAll(PDO::FETCH_ASSOC);

// Tips取得
$tips_query = "
    SELECT title, content
    FROM illaoi_matchup_tips
    WHERE enemy_champ_id = :champ_id
    ORDER BY sort_order
";

$tips_stmt = $db->prepare($tips_query);
$tips_stmt->bindParam(':champ_id', $champ_id);
$tips_stmt->execute();
$tips = $tips_stmt->fetchAll(PDO::FETCH_ASSOC);

// 有利度の色を返す関数
function getAdvantageColor($advantage) {
    switch($advantage) {
        case '◎': return 'text-blue-600';
        case '○': return 'text-green-600';
        case '△': return 'text-yellow-600';
        case '×': return 'text-red-600';
        default: return 'text-gray-500';
    }
}

function getAdvantageBgColor($advantage) {
    switch($advantage) {
        case '◎': return 'bg-blue-100';
        case '○': return 'bg-green-100';
        case '△': return 'bg-yellow-100';
        case '×': return 'bg-red-100';
        default: return 'bg-gray-100';
    }
}
?>

<div class="max-w-6xl mx-auto p-6">
    <a href="index.php" class="mb-4 text-blue-600 hover:text-blue-800 inline-flex items-center gap-2 font-semibold">
        ← 一覧に戻る
    </a>
    
    <div class="bg-white rounded-lg shadow-lg p-8 mt-4">
        <div class="flex items-center justify-between mb-6 border-b pb-4">
            <div>
                <h1 class="text-3xl font-bold text-gray-800"><?php echo htmlspecialchars($detail['champ_name']); ?> 対策</h1>
            </div>
            <span class="text-4xl font-bold <?php echo getAdvantageColor($detail['advantage']); ?> <?php echo getAdvantageBgColor($detail['advantage']); ?> px-4 py-2 rounded-lg">
                <?php echo htmlspecialchars($detail['advantage']); ?>
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="border rounded-lg p-4 bg-gray-50">
                <h3 class="font-bold mb-3 text-lg text-gray-700">推奨ルーン</h3>
                <div class="space-y-2">
                    <?php foreach ($runes as $rune): ?>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-600"><?php echo htmlspecialchars($rune['rune_tree']); ?>:</span>
                        <span class="text-sm text-gray-800"><?php echo htmlspecialchars($rune['rune_name']); ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="border rounded-lg p-4 bg-gray-50">
                <h3 class="font-bold mb-3 text-lg text-gray-700">初手アイテム</h3>
                <div class="text-xl font-semibold text-blue-600">
                    <?php echo htmlspecialchars($detail['first_item_name']); ?>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-blue-500 pb-2 text-gray-800">概要</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($detail['overview'] ?? 'データがまだ登録されていません'); ?></p>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-green-500 pb-2 text-gray-800">序盤の立ち回り</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($detail['early_game'] ?? 'データがまだ登録されていません'); ?></p>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-yellow-500 pb-2 text-gray-800">中盤の立ち回り</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($detail['mid_game'] ?? 'データがまだ登録されていません'); ?></p>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-purple-500 pb-2 text-gray-800">終盤の立ち回り</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($detail['late_game'] ?? 'データがまだ登録されていません'); ?></p>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-blue-500 pb-2 text-gray-800">勝ち筋</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($detail['win_condition'] ?? 'データがまだ登録されていません'); ?></p>
            </section>

            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-red-500 pb-2 text-gray-800">負け筋</h2>
                <p class="text-gray-700 whitespace-pre-wrap"><?php echo htmlspecialchars($detail['lose_condition'] ?? 'データがまだ登録されていません'); ?></p>
            </section>

            <?php if (count($tips) > 0): ?>
            <section>
                <h2 class="text-xl font-bold mb-3 border-b-2 border-indigo-500 pb-2 text-gray-800">Tips・小技</h2>
                <ul class="space-y-3">
                    <?php foreach ($tips as $tip): ?>
                    <li class="border-l-4 border-indigo-500 pl-4 py-2 bg-indigo-50">
                        <h4 class="font-semibold text-gray-800"><?php echo htmlspecialchars($tip['title']); ?></h4>
                        <p class="text-gray-700 mt-1"><?php echo htmlspecialchars($tip['content']); ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>
            <?php endif; ?>
        </div>
    </div>
</div>