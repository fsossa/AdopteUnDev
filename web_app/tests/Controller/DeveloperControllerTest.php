<?php

namespace App\Tests\Controller;

use App\Entity\Developer;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class DeveloperControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private EntityManagerInterface $manager;
    private EntityRepository $repository;
    private string $path = '/home/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->manager = static::getContainer()->get('doctrine')->getManager();
        $this->repository = $this->manager->getRepository(Developer::class);

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
        self::assertPageTitleContains('Developer index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'developer[firstname]' => 'Testing',
            'developer[lastname]' => 'Testing',
            'developer[birthday]' => 'Testing',
            'developer[gender]' => 'Testing',
            'developer[experiences]' => 'Testing',
            'developer[salary]' => 'Testing',
            'developer[biography]' => 'Testing',
            'developer[location]' => 'Testing',
            'developer[avatar]' => 'Testing',
            'developer[user]' => 'Testing',
            'developer[skills]' => 'Testing',
            'developer[my_notes]' => 'Testing',
            'developer[dev_give_notes]' => 'Testing',
        ]);

        self::assertResponseRedirects($this->path);

        self::assertSame(1, $this->repository->count([]));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Developer();
        $fixture->setFirstname('My Title');
        $fixture->setLastname('My Title');
        $fixture->setBirthday('My Title');
        $fixture->setGender('My Title');
        $fixture->setExperiences('My Title');
        $fixture->setSalary('My Title');
        $fixture->setBiography('My Title');
        $fixture->setLocation('My Title');
        $fixture->setAvatar('My Title');
        $fixture->setUser('My Title');
        $fixture->setSkills('My Title');
        $fixture->setMy_notes('My Title');
        $fixture->setDev_give_notes('My Title');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Developer');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Developer();
        $fixture->setFirstname('Value');
        $fixture->setLastname('Value');
        $fixture->setBirthday('Value');
        $fixture->setGender('Value');
        $fixture->setExperiences('Value');
        $fixture->setSalary('Value');
        $fixture->setBiography('Value');
        $fixture->setLocation('Value');
        $fixture->setAvatar('Value');
        $fixture->setUser('Value');
        $fixture->setSkills('Value');
        $fixture->setMy_notes('Value');
        $fixture->setDev_give_notes('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'developer[firstname]' => 'Something New',
            'developer[lastname]' => 'Something New',
            'developer[birthday]' => 'Something New',
            'developer[gender]' => 'Something New',
            'developer[experiences]' => 'Something New',
            'developer[salary]' => 'Something New',
            'developer[biography]' => 'Something New',
            'developer[location]' => 'Something New',
            'developer[avatar]' => 'Something New',
            'developer[user]' => 'Something New',
            'developer[skills]' => 'Something New',
            'developer[my_notes]' => 'Something New',
            'developer[dev_give_notes]' => 'Something New',
        ]);

        self::assertResponseRedirects('/home/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getFirstname());
        self::assertSame('Something New', $fixture[0]->getLastname());
        self::assertSame('Something New', $fixture[0]->getBirthday());
        self::assertSame('Something New', $fixture[0]->getGender());
        self::assertSame('Something New', $fixture[0]->getExperiences());
        self::assertSame('Something New', $fixture[0]->getSalary());
        self::assertSame('Something New', $fixture[0]->getBiography());
        self::assertSame('Something New', $fixture[0]->getLocation());
        self::assertSame('Something New', $fixture[0]->getAvatar());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getSkills());
        self::assertSame('Something New', $fixture[0]->getMy_notes());
        self::assertSame('Something New', $fixture[0]->getDev_give_notes());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();
        $fixture = new Developer();
        $fixture->setFirstname('Value');
        $fixture->setLastname('Value');
        $fixture->setBirthday('Value');
        $fixture->setGender('Value');
        $fixture->setExperiences('Value');
        $fixture->setSalary('Value');
        $fixture->setBiography('Value');
        $fixture->setLocation('Value');
        $fixture->setAvatar('Value');
        $fixture->setUser('Value');
        $fixture->setSkills('Value');
        $fixture->setMy_notes('Value');
        $fixture->setDev_give_notes('Value');

        $this->manager->persist($fixture);
        $this->manager->flush();

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertResponseRedirects('/home/');
        self::assertSame(0, $this->repository->count([]));
    }
}
