<?php require __DIR__ . '/../../Auth/oauth2.php';

use agumil\SatuSehatSDK\Auth\Oauth2;
use agumil\SatuSehatSDK\Builder\PayloadBuilderOrganization;
use agumil\SatuSehatSDK\DataType\Address;
use agumil\SatuSehatSDK\DataType\CodeableConcept;
use agumil\SatuSehatSDK\DataType\Coding;
use agumil\SatuSehatSDK\DataType\CodingMulti;
use agumil\SatuSehatSDK\DataType\ContactPoint;
use agumil\SatuSehatSDK\DataType\ContactPointMulti;
use agumil\SatuSehatSDK\DataType\ExtensionAdministrativeCode;
use agumil\SatuSehatSDK\DataType\HumanName;
use agumil\SatuSehatSDK\HL7\AddressType;
use agumil\SatuSehatSDK\HL7\AddressUse;
use agumil\SatuSehatSDK\HL7\ContactEntityType;
use agumil\SatuSehatSDK\HL7\ContactPointSystem;
use agumil\SatuSehatSDK\HL7\ContactPointUse;
use agumil\SatuSehatSDK\HL7\NameUse;
use agumil\SatuSehatSDK\HL7\OrganizationType;
use agumil\SatuSehatSDK\SSClient;

// init client
$ssclient = new SSClient(new Oauth2($config1), $config2);

// organization data
$id = 'b152874d-20e1-424a-8c3f-e54c6fe09b94';
$name_organization = 'Tes Create Organization RW136';
$type_coding1 = new Coding(
    OrganizationType::SYSTEM,
    OrganizationType::CODE_HEALTHCARE_PROVIDER,
    OrganizationType::getDisplayCode(OrganizationType::CODE_HEALTHCARE_PROVIDER)
);
$type = new CodeableConcept(new CodingMulti($type_coding1));

$contact1 = new ContactPoint(
    ContactPointUse::CODE_WORK,
    ContactPointSystem::CODE_EMAIL,
    'john45doe@oneway.com'
);

$contact2 = new ContactPoint(
    ContactPointUse::CODE_WORK,
    ContactPointSystem::CODE_PHONE,
    '+6281212345678'
);

$address1 = new Address(
    AddressUse::CODE_TEMP,
    AddressType::CODE_BOTH,
    ['Jl. Rajawali No 17'],
    'Umbulharjo',
    'Yogyakarta Kota',
    'DIY',
    '55162',
    'ID'
);
$address1_extension = new ExtensionAdministrativeCode(99, 9901);

$contact_purpose_coding1 = new Coding(
    ContactEntityType::SYSTEM,
    ContactEntityType::CODE_BILLING,
    ContactEntityType::getDisplayCode(ContactEntityType::CODE_BILLING)
);
$contact_purpose = new CodeableConcept(
    new CodingMulti($contact_purpose_coding1)
);

$contact_name = new HumanName(
    NameUse::CODE_OFFICIAL,
    ['Agung', 'Nama Tengah'],
    'Gumilang'
);

$contact_telecom1 = new ContactPoint(
    ContactPointUse::CODE_WORK,
    ContactPointSystem::CODE_PHONE,
    '+6281234567891'
);

// init builder
$builder = new PayloadBuilderOrganization();
$payload = $builder->setName($name_organization)
    ->addType($type)
    ->addTelecom($contact1)
    ->addTelecom($contact2)
    ->addAddress($address1, $address1_extension)
    ->addContact($contact_purpose, $contact_name, new ContactPointMulti($contact_telecom1))
    ->build();

$response = $ssclient->updateOrganization($id, $payload);

var_dump($response->getContentAsObject());
