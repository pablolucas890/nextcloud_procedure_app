<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Pablo Lucas Silva Santos <pablo@amoradev.com>
// SPDX-License-Identifier: AGPL-3.0-or-later
// A classe Application é o principal ponto de entrada de um aplicativo. Essa classe é opcional,
// mas altamente recomendada se seu aplicativo precisar registrar algum serviço ou executar
// algum código para cada solicitação.
// O Nextcloud tentará carregar automaticamente a classe do namespace , como , onde MyApp
// seria o nome do seu aplicativo. O arquivo terá, portanto, a localização
// .\OCA\<App namespace>\AppInfo\Application\OCA\MyApp\AppInfo\Applicationmyapp/lib/AppInfo/Application.php

namespace OCA\Procedure\AppInfo;
use OCP\AppFramework\App;

use OCP\EventDispatcher\IEventDispatcher;
use OCA\Files\Event\LoadAdditionalScriptsEvent;
use OCA\Viewer\Event\LoadViewer;
use OCP\Util;
use OCA\Text\DirectEditing\TextDirectEditor;
use OCP\DirectEditing\RegisterDirectEditorEvent;
use OCP\Files\Events\BeforeFileScannedEvent;

class Application extends App {
	public const APP_ID = 'procedure';

	public function __construct() {
		parent::__construct(self::APP_ID);
		$dispatcher = $this->getContainer()->query(IEventDispatcher::class);
		$dispatcher2 = $this->getContainer()->query(IEventDispatcher::class);

		$dispatcher->addListener(LoadAdditionalScriptsEvent::class, function(LoadAdditionalScriptsEvent $event) {
			//Evento de abrir o arquivo
			Util::addScript(self::APP_ID, 'sidebar');
		});
		$dispatcher2->addListener(TextDirectEditor::class, function(TextDirectEditor $event) {
			//Evento de abri o Viewer
			Util::addScript(self::APP_ID, 'openViewer');
		});
	}

}
