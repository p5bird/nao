<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/19/18
 * Time: 9:26 PM
 */

namespace ObservationBundle\DataFixtures\ORM;

use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use ObservationBundle\Entity\Taxon;

class LoadTaxons extends AbstractFixture {

    public function load(ObjectManager $manager) {

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
                ->setRef($taxons[$i]['CD_REF']);
            $manager->persist($taxon);
        }

        $manager->flush();
    }
}