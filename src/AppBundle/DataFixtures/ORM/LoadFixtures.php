<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/19/18
 * Time: 9:54 PM
 */

namespace AppBundle\DataFixtures\ORM;


use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\Taxon;
use ObservationBundle\Entity\Validation;
use UserBundle\Entity\Group;
use UserBundle\Entity\User;

class LoadFixtures extends AbstractFixture {

    private $position = [
        ['lat' => 48.42096593, 'lng' => -2.16200723],
        ['lat' => 47.08509198, 'lng' => -2.99310982],
        ['lat' => 48.77058708, 'lng' => 3.83533073],
        ['lat' => 47.13560509, 'lng' => 0.62357721],
        ['lat' => 46.68378908, 'lng' => -2.35675788],
        ['lat' => 43.79447739, 'lng' => 3.71290958],
        ['lat' => 45.54283439, 'lng' => -2.90756714],
        ['lat' => 48.38711085, 'lng' => -0.55116748],
        ['lat' => 44.02410162, 'lng' => -1.87059979],
        ['lat' => 49.00899553, 'lng' => 1.5689759],
        ['lat' => 48.84286547, 'lng' => 5.47617482],
        ['lat' => 49.23617486, 'lng' => 4.12697224],
        ['lat' => 44.4303278, 'lng' => 3.43319826],
        ['lat' => 49.21631783, 'lng' => 5.94188689],
        ['lat' => 46.7102627, 'lng' => -1.59240268],
        ['lat' => 43.08140835, 'lng' => 5.11249483],
        ['lat' => 47.66733826, 'lng' => 7.81209854],
        ['lat' => 48.00914974, 'lng' => 3.06486333],
        ['lat' => 43.01628612, 'lng' => 2.2269612],
        ['lat' => 45.82071852, 'lng' => 6.86355052],
        ['lat' => 45.68953913, 'lng' => 6.94079374],
        ['lat' => 46.17875342, 'lng' => 4.75434628],
        ['lat' => 44.41942085, 'lng' => 5.67336527],
        ['lat' => 45.30241623, 'lng' => 0.24313759],
        ['lat' => 46.33727699, 'lng' => -2.51398929],
        ['lat' => 43.85333589, 'lng' => 3.10539173],
        ['lat' => 44.58248962, 'lng' => 2.14795057],
        ['lat' => 44.3754006, 'lng' => 7.10442405],
        ['lat' => 49.01877878, 'lng' => 5.52133162],
        ['lat' => 47.38652629, 'lng' => 2.90393688],
        ['lat' => 47.41669244, 'lng' => -1.07784797],
        ['lat' => 43.08856919, 'lng' => 0.22204258],
        ['lat' => 43.47819184, 'lng' => 3.59827969],
        ['lat' => 46.77236042, 'lng' => 3.70214048],
        ['lat' => 44.21603081, 'lng' => 6.70329029],
        ['lat' => 49.77810404, 'lng' => 0.21436199],
        ['lat' => 49.3649864, 'lng' => 2.4969845],
        ['lat' => 49.23745023, 'lng' => 0.02860492],
        ['lat' => 47.39335347, 'lng' => 0.54134081],
        ['lat' => 48.86607004, 'lng' => 6.4761254],
        ['lat' => 49.4377399, 'lng' => -1.26848254],
        ['lat' => 46.16073791, 'lng' => -2.16869881],
        ['lat' => 47.36498438, 'lng' => 4.39394922],
        ['lat' => 49.36901155, 'lng' => 0.7386008],
        ['lat' => 50.1335492, 'lng' => 1.1161931],
        ['lat' => 47.78241833, 'lng' => 1.41237104],
        ['lat' => 46.44474761, 'lng' => 7.92985374],
        ['lat' => 44.22898888, 'lng' => 4.06935037],
        ['lat' => 44.73650883, 'lng' => -2.5291656],
        ['lat' => 45.80781588, 'lng' => 7.26322732],
        ['lat' => 45.3274505, 'lng' => 2.37272654],
        ['lat' => 47.75809529, 'lng' => 3.21579994],
        ['lat' => 46.24644902, 'lng' => 5.82668954],
        ['lat' => 49.62341458, 'lng' => 2.97869432],
        ['lat' => 48.66406745, 'lng' => 0.96718838],
        ['lat' => 45.9010038, 'lng' => 6.89369811],
        ['lat' => 49.85912261, 'lng' => 3.70313772],
        ['lat' => 48.57546094, 'lng' => 0.78205465],
        ['lat' => 50.42961359, 'lng' => 2.56542691],
        ['lat' => 45.53731211, 'lng' => 3.08812058],
        ['lat' => 44.07653891, 'lng' => 0.57780104],
        ['lat' => 44.86824527, 'lng' => 0.5753263],
        ['lat' => 48.72300918, 'lng' => -1.6278606],
        ['lat' => 44.53319211, 'lng' => -1.59058422],
        ['lat' => 48.66269575, 'lng' => 3.47293768],
        ['lat' => 47.67947578, 'lng' => 4.00818825],
        ['lat' => 48.07615319, 'lng' => -1.31901695],
        ['lat' => 48.76110074, 'lng' => -1.07346409],
        ['lat' => 49.5026331, 'lng' => 3.67103476],
        ['lat' => 47.41100204, 'lng' => -1.13454274],
        ['lat' => 45.65215196, 'lng' => -3.23805437],
        ['lat' => 48.44994265, 'lng' => -1.76821419],
        ['lat' => 46.26432417, 'lng' => 0.86505668],
        ['lat' => 49.08961869, 'lng' => 2.59240127],
        ['lat' => 45.2690308, 'lng' => 3.01190505],
        ['lat' => 42.91404539, 'lng' => 4.8123894],
        ['lat' => 46.83324691, 'lng' => -1.46223248],
        ['lat' => 48.76663196, 'lng' => 3.51671113],
        ['lat' => 43.06307271, 'lng' => 1.22697199],
        ['lat' => 48.32307155, 'lng' => 2.056595],
        ['lat' => 45.1105747, 'lng' => 2.01708939],
        ['lat' => 48.48254031, 'lng' => 2.15316382],
        ['lat' => 47.56767213, 'lng' => 6.24977636],
        ['lat' => 44.84399437, 'lng' => 5.97282622],
        ['lat' => 45.96573897, 'lng' => 4.73612762],
        ['lat' => 45.074171, 'lng' => -2.0689248],
        ['lat' => 48.94041405, 'lng' => 5.20976407],
        ['lat' => 50.48238697, 'lng' => 3.40971869],
        ['lat' => 44.19739805, 'lng' => -1.81088062],
        ['lat' => 49.05481272, 'lng' => 3.07046233],
        ['lat' => 49.50349976, 'lng' => 3.02814421],
        ['lat' => 44.36891525, 'lng' => -0.58682304],
        ['lat' => 49.91826229, 'lng' => 4.12823555],
        ['lat' => 47.78878338, 'lng' => 7.81583932],
        ['lat' => 44.08726369, 'lng' => 5.10670684],
        ['lat' => 46.24695993, 'lng' => 7.86855922],
        ['lat' => 48.01221168, 'lng' => 6.1304078],
        ['lat' => 44.37543952, 'lng' => 3.47507452],
        ['lat' => 47.7147813, 'lng' => 0.79155046],
        ['lat' => 44.38006469, 'lng' => 6.18813696],
        ['lat' => 48.87901106, 'lng' => 0.40975965],
        ['lat' => 43.44607079, 'lng' => 2.60101156],
        ['lat' => 45.74101559, 'lng' => 4.23515223],
        ['lat' => 43.93624012, 'lng' => 1.76300271],
        ['lat' => 49.75448487, 'lng' => 5.91204311],
        ['lat' => 49.17811306, 'lng' => 5.58567625],
        ['lat' => 43.52054894, 'lng' => 4.8603887],
        ['lat' => 49.57948717, 'lng' => 6.06360854],
        ['lat' => 49.9312992, 'lng' => 0.66125199],
        ['lat' => 44.4467733, 'lng' => -1.16271235],
        ['lat' => 49.05238107, 'lng' => 3.25829282],
        ['lat' => 43.3448331, 'lng' => -0.73709228],
        ['lat' => 49.45294126, 'lng' => 2.50311455],
        ['lat' => 48.05939603, 'lng' => 5.77366189],
        ['lat' => 44.32187276, 'lng' => 6.70570152],
        ['lat' => 47.14819515, 'lng' => -0.92203334],
        ['lat' => 45.96617755, 'lng' => -2.44685245],
        ['lat' => 43.93027497, 'lng' => -0.0886938],
        ['lat' => 49.89848515, 'lng' => 3.920483],
        ['lat' => 50.12312446, 'lng' => 2.50880414],
        ['lat' => 50.20493046, 'lng' => 2.24882678],
        ['lat' => 49.74221372, 'lng' => 5.3595736],
        ['lat' => 49.33897379, 'lng' => 5.97968372],
        ['lat' => 42.83286093, 'lng' => 2.25073223],
        ['lat' => 50.07777294, 'lng' => 0.43841695],
        ['lat' => 45.27259129, 'lng' => 3.7940052],
        ['lat' => 45.51490261, 'lng' => 7.58720518],
        ['lat' => 44.46296159, 'lng' => -1.35176291],
        ['lat' => 46.55928076, 'lng' => -2.53660935],
        ['lat' => 47.97070657, 'lng' => 0.13967784],
        ['lat' => 48.81520763, 'lng' => 2.29392168],
        ['lat' => 47.41399207, 'lng' => -3.28145008],
        ['lat' => 46.33677164, 'lng' => 1.40926265],
        ['lat' => 46.45219322, 'lng' => 3.57039144],
        ['lat' => 46.1163104, 'lng' => 3.70296952],
        ['lat' => 45.97700047, 'lng' => 5.37728416],
        ['lat' => 45.3557569, 'lng' => 3.23818679],
        ['lat' => 47.66413598, 'lng' => 7.62103077],
        ['lat' => 45.56206382, 'lng' => -2.25269916],
        ['lat' => 43.8726832, 'lng' => 2.46300002],
        ['lat' => 43.44391592, 'lng' => 5.22561654],
        ['lat' => 47.75044086, 'lng' => 4.05871236],
        ['lat' => 48.20630782, 'lng' => 1.49324536],
        ['lat' => 47.44929927, 'lng' => 5.9987855],
        ['lat' => 48.2407636, 'lng' => 0.34287173],
        ['lat' => 45.04174334, 'lng' => 7.37686065],
        ['lat' => 47.81302461, 'lng' => -0.11933371],
        ['lat' => 46.83893501, 'lng' => 3.23370278],
        ['lat' => 47.53500521, 'lng' => 3.12572167],
        ['lat' => 45.09109506, 'lng' => 1.77553348],
        ['lat' => 44.4700491, 'lng' => 1.56509466],
        ['lat' => 48.02573442, 'lng' => -1.19649668],
        ['lat' => 43.01025932, 'lng' => 4.09731313],
        ['lat' => 44.05497784, 'lng' => -1.17273731],
        ['lat' => 48.51476917, 'lng' => 6.87156671],
        ['lat' => 45.54269697, 'lng' => 2.65581761],
        ['lat' => 48.79092511, 'lng' => 5.07126371],
        ['lat' => 44.51673433, 'lng' => -1.63761329],
        ['lat' => 48.8068649, 'lng' => -1.3902861],
        ['lat' => 50.32544509, 'lng' => 0.69932044],
        ['lat' => 44.0013028, 'lng' => 1.1838602],
        ['lat' => 49.2641159, 'lng' => 4.87550951],
        ['lat' => 44.00589672, 'lng' => 0.98891808],
        ['lat' => 46.12362743, 'lng' => -2.54606936],
        ['lat' => 44.57522191, 'lng' => 1.15896784],
        ['lat' => 46.54786481, 'lng' => 2.21930463],
        ['lat' => 49.03769752, 'lng' => 1.62278495],
        ['lat' => 45.24899753, 'lng' => 6.05101802],
        ['lat' => 46.37989024, 'lng' => 2.54809403],
        ['lat' => 46.46076565, 'lng' => 0.88214818],
        ['lat' => 44.68687886, 'lng' => 6.52598053],
        ['lat' => 45.92553755, 'lng' => -0.81582474],
        ['lat' => 50.50644509, 'lng' => 1.36552693],
        ['lat' => 43.873469, 'lng' => 0.25165989],
        ['lat' => 49.69726451, 'lng' => -0.00512576],
        ['lat' => 46.88423069, 'lng' => 5.1700455],
        ['lat' => 44.69648111, 'lng' => 3.01530418],
        ['lat' => 46.50728512, 'lng' => 6.30191048],
        ['lat' => 47.69426512, 'lng' => 1.23709444],
        ['lat' => 43.8941083, 'lng' => 5.29624875],
        ['lat' => 48.00127288, 'lng' => 6.76237301],
        ['lat' => 47.58386551, 'lng' => 0.11532798],
        ['lat' => 44.68847529, 'lng' => 0.3430699],
        ['lat' => 47.66253923, 'lng' => 7.70493841],
        ['lat' => 45.7699787, 'lng' => 4.23126789],
        ['lat' => 49.42647423, 'lng' => 1.69316639],
        ['lat' => 43.11502033, 'lng' => 3.75584022],
        ['lat' => 45.38733935, 'lng' => 4.46223149],
        ['lat' => 45.78381763, 'lng' => -1.93314571],
        ['lat' => 45.88602116, 'lng' => 0.30626959],
        ['lat' => 43.77364809, 'lng' => 1.30680876],
        ['lat' => 44.29444135, 'lng' => -0.94843948],
        ['lat' => 48.03518277, 'lng' => 3.31736512],
        ['lat' => 48.13590842, 'lng' => 6.63296901],
        ['lat' => 47.73068496, 'lng' => -1.16584194],
        ['lat' => 44.62152554, 'lng' => -0.25931109],
        ['lat' => 43.88140922, 'lng' => 4.70611839],
        ['lat' => 46.47430043, 'lng' => 3.63712192],
        ['lat' => 46.53233903, 'lng' => -0.46603212],
        ['lat' => 45.61789847, 'lng' => -1.04056621]
    ];

    public function load(ObjectManager $manager) {
        $this->loadUsers($manager);
        $this->loadGroups($manager);
        $this->loadTaxons($manager);
        $this->loadObservations($manager);
    }

    private function loadUsers(ObjectManager $manager) {
        $user = new User();

        $user->setUsername('admin');
        $user->setPlainPassword('admin');
        $user->setEmail('gatienhrd@gmail.com');

        $manager->persist($user);
        $manager->flush();
    }

    private function loadTaxons(ObjectManager $manager){
        $csv = 'web/taxref/taxref.csv';

        $taxons = array_map('str_getcsv', file($csv));
        array_walk($taxons, function(&$a) use ($taxons) {
            $a = array_combine($taxons[0], $a);
        });
        array_shift($taxons);


        for ($i = 0; $i < count($taxons); $i++) {
            $taxon = new Taxon();

            $taxon
                ->setAuthor($taxons[$i]['LB_AUTEUR'])
                ->setName($taxons[$i]['LB_NOM'])
                ->setClass($taxons[$i]['CLASSE'])
                ->setFamily($taxons[$i]['FAMILLE'])
                ->setNameValid($taxons[$i]['NOM_VALIDE'])
                ->setNameVern($taxons[$i]['NOM_VERN'])
                ->setNameVernEN($taxons[$i]['NOM_VERN_ENG'])
                ->setOrder($i)
                ->setPhylum($taxons[$i]['PHYLUM'])
                ->setReign($taxons[$i]['REGNE'])
                ->setRef($taxons[$i]['CD_REF'])
                ->setNameFr($taxons[$i]['FR'])
                ->setNameEn($taxons[$i]['GF']);

            $manager->persist($taxon);
        }

        $manager->flush();
    }

    private function loadObservations(ObjectManager $manager){
        $taxon = $manager
            ->getRepository('ObservationBundle:Taxon')
            ->findOneBy(['id' => '10']);

        $user = $manager
            ->getRepository('UserBundle:User')
            ->findOneBy(['username' => 'admin']);

        for ($i = 0; $i < 20; $i++) {
            if ($taxon) {
                $observation = new Observation();

                $observation->setComment('observation importée par Fixtures');
                $observation->setAuthor($user);
                $observation->setNoName(false);
                $observation->setBirdName($taxon->getNameFr());
                $observation->setTaxon($taxon);

                $timestamp = mt_rand(strtotime("Jan 01 2000"), strtotime("Jan 01 2018"));
                $randomDate = date("Y-m-d", $timestamp);
                $observation->setDay(new \DateTime($randomDate));

                $validation = new Validation();
                $validation->setAuthor($user);
                $validation->setDate(new \DateTime());
                $validation->setGranted(true);

                $observation->setValidation($validation);
                $observation->setPublish(true);

                $observation->setLatitude($this->position[$i]['lat']);
                $observation->setLongitude($this->position[$i]['lng']);

                $manager->persist($observation);
            }
        }

        $manager->flush();
    }

    private function loadGroups(ObjectManager $manager) {
        $options = array(
            'Poussin' => array('ROLE_USER'),
            'Colibri' => array('ROLE_USER'),
            'Pivert' => array('ROLE_USER'),
            'Faucon' => array('ROLE_SPECIALISTE'),
            'Condor' => array('ROLE_SPECIALISTE'),
        );

        foreach ($options as $key => $value) {

            $group = new Group($key, $value);

            $manager->persist($group);
        }

        $manager->flush();
    }
}