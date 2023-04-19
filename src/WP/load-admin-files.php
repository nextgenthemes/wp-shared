<?php declare(strict_types=1);
namespace Nextgenthemes\WP;

if ( is_admin() ) {
	require_once __DIR__ . '/Admin/EDD/PluginUpdater.php';
	require_once __DIR__ . '/Admin/EDD/ThemeUpdater.php';
	require_once __DIR__ . '/Admin/Notices.php';
}
