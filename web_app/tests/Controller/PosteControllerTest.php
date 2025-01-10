<?php

namespace App\Tests\Controller;

use App\Entity\Poste;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class PosteControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/poste/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Poste::class);

        foreach ($this->repository->findAll() as $object) {
            $this->manager->remove($object);
        }

        $this->manager->flush();
    }

    public function testIndex(): void
    {
        $this->client->followRedirects();
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Poste index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'poste[title]' => 'Testing',
            'poste[description]' => 'Testing',
            'poste[location]' => 'Testing',
            'poste[experiences]' => 'Testing',
            'poste[min_salary]' => 'Testing',
            'poste[max_salary]' => 'Testing',
            'poste[created_at]' => 'Testing',
            'poste[updated_at]' => 'Testing',
            'poste[company]' => 'Testing',
            'poste[skills]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Poste();
        $fixture->setTitle('My Title');
        $fixture->setDescription('My Title');
        $fixture->setLocation('My Title');
        $fixture->setExperiences('My Title');
        $fixture->setMin_salary('My Title');
        $fixture->setMax_salary('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setCompany('My Title');
        $fixture->setSkills('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Poste');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Poste();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setLocation('Value');
        $fixture->setExperiences('Value');
        $fixture->setMin_salary('Value');
        $fixture->setMax_salary('Value');
        $fixture->setCreated_at('Value');
        $fixture->setUpdated_at('Value');
        $fixture->setCompany('Value');
        $fixture->setSkills('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'poste[title]' => 'Something New',
            'poste[description]' => 'Something New',
            'poste[location]' => 'Something New',
            'poste[experiences]' => 'Something New',
            'poste[min_salary]' => 'Something New',
            'poste[max_salary]' => 'Something New',
            'poste[created_at]' => 'Something New',
            'poste[updated_at]' => 'Something New',
            'poste[company]' => 'Something New',
            'poste[skills]' => 'Something New',
        ]);

        self::assertResponseRedirects('/poste/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitle());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getExperiences());
        self::assertSame('Something New', $fixture[0]->getMin_salary());
        self::assertSame('Something New', $fixture[0]->getMax_salary());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
        self::assertSame('Something New', $fixture[0]->getCompany());
        self::assertSame('Something New', $fixture[0]->getSkills());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Poste();
        $fixture->setTitle('Value');
        $fixture->setDescription('Value');
        $fixture->setLocation('Value');
        $fixture->setExperiences('Value');
        $fixture->setMin_salary('Value');
        $fixture->setMax_salary('Value');
        $fixture->setCreated_at('Value');
        $fixture->setUpdated_at('Value');
        $fixture->setCompany('Value');
        $fixture->setSkills('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/poste/');
        self::assertSame(0, $this->repository->count([]));
    }
}
