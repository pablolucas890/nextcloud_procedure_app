<?php
declare(strict_types=1);
// SPDX-FileCopyrightText: Pablo Lucas Silva Santos <pablo@amoradev.com>
// SPDX-License-Identifier: AGPL-3.0-or-later

namespace OCA\Procedure\Tests\Unit\Controller;

use OCA\Procedure\Controller\NoteApiController;

class NoteApiControllerTest extends NoteControllerTest {
	public function setUp(): void {
		parent::setUp();
		$this->controller = new NoteApiController($this->request, $this->service, $this->userId);
	}
}
