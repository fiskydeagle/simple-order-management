<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Country;
use App\Entity\Note;
use App\Entity\Order;
use App\Entity\Product;
use App\Repository\CountryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    private $faker;
    private $countryRespository;
    private $countries;

    public function __construct(CountryRepository $countryRespository)
    {
        $this->faker = \Faker\Factory::create();
        $this->countryRespository = $countryRespository;
        $this->countries = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Kosovo", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Zambia", "Zimbabwe");
    }

    public function load(ObjectManager $manager)
    {
        $this->loadProducts($manager);
        $this->loadCountries($manager);
        $this->loadOrders($manager);
    }

    public function loadProducts(ObjectManager $manager)
    {
        for ($i = 0; $i < 10; $i++) {
            $product = new Product();

            $product->setName($this->faker->sentence);
            $product->setDescription($this->faker->realText());
            $product->setPrice($this->faker->randomFloat(2,10,100));

            $this->setReference('product_' . $i, $product);

            $manager->persist($product);
        }

        $manager->flush();
    }

    public function loadCountries(ObjectManager $manager)
    {
        foreach ($this->countries as $countryName) {
            $country = new Country();

            $country->setName($countryName);

            $manager->persist($country);
        }

        $manager->flush();
    }

    public function loadOrders(ObjectManager $manager) {
        for ($i = 0; $i < 10; $i++) {
            $order = new Order();

            $order->setPosition(Order::POSITON_SUCCESS);

            $billingAddress = new Address();
            $randomCountryName = array_rand($this->countries);
            $billingAddress->setCountry(
                $this->countryRespository->findOneBy(array('name' => $this->countries[$randomCountryName]))
            );
            $billingAddress->setAddress($this->faker->address);
            $billingAddress->setEmail($this->faker->email);
            $billingAddress->setPhone($this->faker->phoneNumber);
            $billingAddress->setZipCode($this->faker->postcode);

            $manager->persist($billingAddress);

            $order->setBillingAddress($billingAddress);

            $shippingAddress = new Address();
            $randomCountryName = array_rand($this->countries);
            $shippingAddress->setCountry(
                $this->countryRespository->findOneBy(array('name' => $this->countries[$randomCountryName]))
            );
            $shippingAddress->setAddress($this->faker->address);
            $shippingAddress->setEmail($this->faker->email);
            $shippingAddress->setPhone($this->faker->phoneNumber);
            $shippingAddress->setZipCode($this->faker->postcode);

            $manager->persist($shippingAddress);

            $order->setShippigAddress($shippingAddress);

            for ($j = 0; $j < rand(1, 10); $j++) {
                $order->addProduct(
                    $this->getReference('product_' . $j)
                );
            }

            for ($j = 0; $j < rand(1, 5); $j++) {
                $note = new Note();
                $note->setDescription($this->faker->realText());
                $manager->persist($note);

                $order->addNote($note);
            }

            $manager->persist($order);
        }

        $manager->flush();
    }
}
