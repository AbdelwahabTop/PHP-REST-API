<?php

class ProductController
{
    public function __construct(private ProductGateway $gateWay)
    {
        
    }

    public function processRequest(string $method, ?string $id): void
    {
        if ($id) {

            $this->processResourceRequest($method, $id);

        } else {

            $this->processCollectionRequest($method);

        }
    }

    private function processResourceRequest(string $method, string $id): void
    {   
    }

    private function processCollectionRequest(string $method): void
    {
        switch ($method) {
            case "GET":
                echo json_encode($this->gateWay->getAll());
                break;

            case "POST":
                $data = (array) json_decode(file_get_contents("php://input"), true);

                $id = $this->gateWay->create($data);

                http_response_code(201);
                echo json_encode([
                    "message" => "Product created",
                    "id" => $id
                ]);
                break;
        }
    }
}