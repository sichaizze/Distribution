<?php

namespace Claroline\CoreBundle\Tests\NewAPI;

use Claroline\CoreBundle\API\SerializerProvider;
use Claroline\Corebundle\API\ValidatorProvider;
use Claroline\CoreBundle\Library\Testing\TransactionalTestCase;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

class SerializerProviderTest extends TransactionalTestCase
{
    /** @var SerializerProvider */
    private $provider;
    /** @var mixed[] */
    private $serializers;

    protected function setUp()
    {
        parent::setUp();
        $this->provider = $this->client->getContainer()->get('claroline.api.serializer');
        $this->validator = $this->client->getContainer()->get('claroline.api.validator');
        $this->sampleDir = $this->client->getContainer()->getParameter('claroline.api.sample.dir');

        $tokenStorage = $this->client->getContainer()->get('security.token_storage');
        $token = new AnonymousToken('key', 'anon.');
        $tokenStorage->setToken($token);
    }

    /**
     * @dataProvider getHandledClassesProvider
     *
     * @param string $class
     *
     * If json il malformed, a syntax error will be thrown
     */
    public function testSchema($class)
    {
        if ($this->provider->hasSchema($class)) {
            $schema = $this->provider->getSchema($class);
            $this->assertTrue(is_object($schema));
        } else {
            $this->markTestSkipped('No schema defined for class '.$class);
        }
    }

    /**
     * @dataProvider getHandledClassesProvider
     *
     * @param string $class
     */
    public function testSerializer($class)
    {
        //login
        if ($this->provider->hasSchema($class) && $this->provider->getSampleDirectory($class)) {
            $iterator = new \DirectoryIterator($this->provider->getSampleDirectory($class).'/valid/create');

            foreach ($iterator as $file) {
                if ($file->isFile()) {
                    $data = \file_get_contents($file->getPathName());
                    //let's test the deserializer
                    $object = $this->provider->deserialize($class, json_decode($data, true));
                    //can we serialize it ?
                    $data = $this->provider->serialize($object);
                    //is the result... valid ?
                    $errors = $this->validator->validate($class, $data, ValidatorProvider::CREATE);
                    $this->assertTrue(count($errors) === 0/*, print_r([$this->validator->toObject($data), $errors], true)*/);
                }
            }
        } else {
            $this->markTestSkipped('No schema defined for class'.$class);
        }
    }

    /**
     * @return [][]
     */
    public function getHandledClassesProvider()
    {
        parent::setUp();
        $provider = $this->client->getContainer()->get('claroline.api.serializer');

        return array_map(function ($serializer) use ($provider) {
            return [$provider->getSerializerHandledClass($serializer)];
        }, $provider->all());
    }
}
