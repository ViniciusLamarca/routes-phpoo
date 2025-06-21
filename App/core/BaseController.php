<?php

namespace App\Core;

use App\Core\Container\Container;
use App\Core\Http\Request;
use App\Core\Http\Response;
use App\Core\View\ViewFactory;
use App\Core\Session\SessionManager;

abstract class BaseController
{
    protected Container $container;
    protected ViewFactory $view;
    protected SessionManager $session;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->view = $container->make(ViewFactory::class);
        $this->session = $container->make(SessionManager::class);
    }

    protected function render(string $view, array $data = []): string
    {
        return $this->view->render($view, $data);
    }

    protected function response(string $content = '', int $statusCode = 200): Response
    {
        return new Response($content, $statusCode);
    }

    protected function json(array $data, int $statusCode = 200): Response
    {
        return (new Response())->json($data, $statusCode);
    }

    protected function redirect(string $url, int $statusCode = 302): Response
    {
        return (new Response())->redirect($url, $statusCode);
    }

    protected function back(): Response
    {
        $referer = $_SERVER['HTTP_REFERER'] ?? '/';
        return $this->redirect($referer);
    }

    protected function withErrors(array $errors): self
    {
        $this->session->put('errors', $errors);
        return $this;
    }

    protected function withSuccess(string $message): self
    {
        $this->session->put('success', $message);
        return $this;
    }

    protected function withInput(array $input): self
    {
        $this->session->put('old_input', $input);
        return $this;
    }

    protected function old(string $key, $default = null)
    {
        $oldInput = $this->session->get('old_input', []);
        return $oldInput[$key] ?? $default;
    }

    protected function validate(Request $request, array $rules): array
    {
        // Implementação básica de validação
        // Em um projeto real, seria mais robusta
        $errors = [];
        $data = [];

        foreach ($rules as $field => $rule) {
            $value = $request->input($field);

            if (str_contains($rule, 'required') && empty($value)) {
                $errors[$field] = "O campo {$field} é obrigatório";
                continue;
            }

            if (str_contains($rule, 'email') && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                $errors[$field] = "O campo {$field} deve ser um email válido";
                continue;
            }

            $data[$field] = $value;
        }

        if (!empty($errors)) {
            throw new ValidationException($errors);
        }

        return $data;
    }
}

class ValidationException extends \Exception
{
    private array $errors;

    public function __construct(array $errors)
    {
        $this->errors = $errors;
        parent::__construct('Validation failed');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
