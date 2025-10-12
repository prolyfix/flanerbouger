<?php

namespace App\Tests\Controller\Frontend;

use App\Entity\NewsletterRegistration;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

final class NewsletterRegistrationControllerTest extends WebTestCase
{
    public function testIndex(): void
    {
        $client = static::createClient();
        //if get get 400
        $client->request('GET', '/newsletter/registration');
        self::assertResponseStatusCodeSame(405);

        //if post without email get 400
        $client->request('POST', '/newsletter/registration');
        self::assertResponseStatusCodeSame(400);

        //if post with email and wrong email format get 400
        $client->request('POST', '/newsletter/registration', ['email' => 'notanemail']);
        self::assertResponseStatusCodeSame(400);

        $email = uniqid().'@example.com';

        //if post with email get 201
        $client->request('POST', '/newsletter/registration', ['email' => $email]);
        self::assertResponseStatusCodeSame(201);

        //if post with same email get 400
        $client->request('POST', '/newsletter/registration', ['email' => $email]);
        self::assertResponseStatusCodeSame(400);
    }

    public function testValidate(): void
    {
        $client = static::createClient();

        //register a new email
        $email = uniqid().'@example.com';
        $client->request('POST', '/newsletter/registration', ['email' => $email]);
        self::assertResponseStatusCodeSame(201);

        //get the uniqueId from database
        $entityManager = $client->getContainer()->get('doctrine')->getManager();
        $registration = $entityManager->getRepository(NewsletterRegistration::class)->findOneBy(['email' => $email]);
        $uniqueId = $registration->getUniqIdentification();


        //if get with wrong uniqueId get 404
        $client->request('GET', '/newsletter/validation/wronguniqueid');
        self::assertResponseStatusCodeSame(404);

        //if get with correct uniqueId get 200
        $client->request('GET', '/newsletter/validation/'.$uniqueId);
        self::assertResponseStatusCodeSame(200);

    }

}
