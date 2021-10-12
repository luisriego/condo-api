<?php

declare(strict_types=1);

namespace App\Tests\Functional\Movement;

use App\Tests\Functional\FunctionalTestBase;
use Doctrine\DBAL\DBALException;

class MovementTestBase extends FunctionalTestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/movements';
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getLuisCondoId()
    {
        return $this->initDbConnection()->query('SELECT id FROM condo WHERE fantasy_name = "Luis Condo"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getLuisCondoAccountId()
    {
        return $this->initDbConnection()->query('SELECT id FROM account WHERE name = "Conta Condominio"')->fetchColumn(0);
    }

    /**
     * @return false|mixed
     *
     * @throws DBALException
     */
    protected function getLuisCondoCategoryId()
    {
        return $this->initDbConnection()->query('SELECT id FROM category WHERE name = "Categoria 1"')->fetchColumn(0);
    }
}