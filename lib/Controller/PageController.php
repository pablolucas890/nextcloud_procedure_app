<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Pablo Lucas Silva Santos <pablo@Procedure.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Procedure\Controller;

use OCA\Procedure\AppInfo\Application;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\TemplateResponse;
use OCP\IRequest;
use OCP\Util;

class PageController extends Controller {
	public function __construct(IRequest $request) {
		parent::__construct(Application::APP_ID, $request);
	}

	/**
	 * @NoAdminRequired
	 * @NoCSRFRequired
	 */
	public function index(): TemplateResponse {
		// Adiciona o Script principal quando a rota index e chamada
		Util::addScript(Application::APP_ID, 'procedure-main');
		// Retorna o templete apos um get de / no navegador
		return new TemplateResponse(Application::APP_ID, 'main');
	}
}
