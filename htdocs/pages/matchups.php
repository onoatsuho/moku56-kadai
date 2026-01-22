<?php
$database = new Database();
$db = $database->getConnection();

// 検索機能
$search = isset($_GET['search']) ? $_GET['search'] : '';

// マッチアップ一覧取得
$query = "
    SELECT
        c.id,
        c.champ_name,
        s.advantage,
        r.rune_name AS keystone_name,
        i.item_name AS first_item_name
    FROM illaoi_matchup_summary s
    JOIN champ_data c ON c.id = s.enemy_champ_id
    JOIN rune_pages rp ON rp.id = s.rune_page_id
    JOIN runes r ON r.id = rp.keystone_rune_id
    JOIN items i ON i.id = s.first_item_id
";

if ($search) {
    $query .= " WHERE c.champ_name LIKE :search";
}

$query .= " ORDER BY c.champ_name";

$stmt = $db->prepare($query);

if ($search) {
    $search_param = "%{$search}%";
    $stmt->bindParam(':search', $search_param);
}

$stmt->execute();
$matchups = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<div class="max-w-7xl mx-auto p-6">
    <!-- 検索バー -->
    <div class="mb-6">
        <form method="GET" action="index.php" class="relative">
            <svg class="absolute left-3 top-3 text-gray-400" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="11" cy="11" r="8"></circle>
                <path d="m21 21-4.35-4.35"></path>
            </svg>
            <input
                type="text"
                name="search"
                placeholder="チャンピオン名で検索..."
                value="<?php echo htmlspecialchars($search); ?>"
                class="w-full pl-10 pr-4 py-3 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
        </form>
    </div>

    <!-- マッチアップ一覧 -->
    <div class="bg-white rounded-lg shadow-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50 border-b">
                <tr>
                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-700">チャンピオン</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">有利度</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">キーストーン</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700">初手アイテム</th>
                    <th class="px-6 py-4 text-center text-sm font-semibold text-gray-700"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                <?php foreach ($matchups as $matchup): ?>
                <tr class="hover:bg-gray-50 cursor-pointer transition" onclick="location.href='?id=<?php echo $matchup['id']; ?>'">
                    <td class="px-6 py-4">
                        <span class="font-semibold text-gray-800 text-lg"><?php echo htmlspecialchars($matchup['champ_name']); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-2xl font-bold <?php echo getAdvantageColor($matchup['advantage']); ?> <?php echo getAdvantageBgColor($matchup['advantage']); ?> px-3 py-1 rounded">
                            <?php echo htmlspecialchars($matchup['advantage']); ?>
                        </span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-gray-700"><?php echo htmlspecialchars($matchup['keystone_name']); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-medium text-gray-700"><?php echo htmlspecialchars($matchup['first_item_name']); ?></span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <svg class="text-gray-400 inline" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6"></polyline>
                        </svg>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>