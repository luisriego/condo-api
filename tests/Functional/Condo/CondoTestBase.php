<?php

declare(strict_types=1);

namespace App\Tests\Functional\Condo;

use App\Tests\Functional\FunctionalTestBase;
use Doctrine\DBAL\DBALException;

class CondoTestBase extends FunctionalTestBase
{
    protected string $endpoint;

    public function setUp(): void
    {
        parent::setUp();

        $this->endpoint = '/api/v1/condos';
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
}