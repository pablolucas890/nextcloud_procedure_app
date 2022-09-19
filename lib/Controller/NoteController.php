<?php
namespace OCA\Procedure\Controller;

use OCP\IRequest;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Controller;

use OCA\Procedure\Service\NoteService;

class NoteController extends Controller {

    private $service;
    private $userId;

    // Para retono de erros
    use Errors;

    public function __construct(string $AppName, IRequest $request, NoteService $service, $UserId){
        parent::__construct($AppName, $request);
        $this->service = $service;
        $this->userId = $UserId;
    }

    /**
     * @NoAdminRequired
     */

    // Funcao de listagen de todas as notas, ela recebe os dados da rota e comunica com service
    public function index() {
        return new DataResponse($this->service->findAll($this->userId));
    }

    /**
     * @NoAdminRequired
     *
     * @param int $id
     */

    // Funcao de lestagem de nota, ela recebe os dados da rota e comunica com service
    public function show(int $id) {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->find($id, $this->userId);
        });
    }

    /**
     * @NoAdminRequired
     *
     * @param string $title
     * @param string $content
     */

    // Funcao de criacao de nota, ela recebe os dados da rota e comunica com service
    public function create(string $title, string $content) {
        return $this->service->create($title, $content, $this->userId);
    }

    /**
     * @NoAdminRequired
     *
     * @param int $id
     * @param string $title
     * @param string $content
     */

    // Funcao de atualizacao de nota, ela recebe os dados da rota e comunica com service
    public function update(int $id, string $title, string $content) {
        return $this->handleNotFound(function () use ($id, $title, $content) {
            return $this->service->update($id, $title, $content, $this->userId);
        });
    }

    /**
     * @NoAdminRequired
     *
     * @param int $id
     */

    // Funcao de remocao de nota, ela recebe os dados da rota e comunica com service
    public function destroy(int $id) {
        return $this->handleNotFound(function () use ($id) {
            return $this->service->delete($id, $this->userId);
        });
    }

}