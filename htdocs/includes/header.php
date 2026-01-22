<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>イラオイ専用Wiki</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <header class="bg-gradient-to-r from-blue-600 to-blue-800 text-white shadow-lg">
        <div class="max-w-7xl mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center text-blue-600 font-bold text-xl">
                        I
                    </div>
                    <h1 class="text-2xl font-bold">イラオイ専用Wiki</h1>
                </div>
                <nav class="flex gap-4">
                    <a href="index.php" class="px-4 py-2 rounded-lg font-semibold transition <?php echo (!isset($_GET['page']) || $_GET['page'] == 'matchups') ? 'bg-white text-blue-600' : 'bg-blue-700 hover:bg-blue-600'; ?>">
                        マッチアップ
                    </a>
                    <a href="?page=forum" class="px-4 py-2 rounded-lg font-semibold transition flex items-center gap-2 <?php echo (isset($_GET['page']) && $_GET['page'] == 'forum') ? 'bg-white text-blue-600' : 'bg-blue-700 hover:bg-blue-600'; ?>">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                        </svg>
                        掲示板
                    </a>
                </nav>
            </div>
        </div>
    </header>