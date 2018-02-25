<?php

namespace ObservationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

use ObservationBundle\Entity\Observation;
use ObservationBundle\Entity\Taxon;
use ObservationBundle\Entity\Image;
use ObservationBundle\Entity\Validation;
use ObservationBundle\Entity\Search;

use ObservationBundle\Service\SearchFiltered;
use ObservationBundle\Service\Geoloc;
use ObservationBundle\Service\TaxonFinder;
use ObservationBundle\Service\ObsValidation;

class AjaxController extends Controller
{

    /**
     * @param  string $birdName Partial bird name
     * @return JsonResponse     List of proposed names
     */
    public function birdNameAutoCompleteAction($birdName)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Taxon');
        $taxons = $repository->findForAutocomplete($birdName);

        $taxonList = [];
        foreach ($taxons as $taxon) {
            array_push($taxonList, [
                'label' => $taxon->getNameVern() . ' :: ' . $taxon->getNameValid(),
                'value' => $taxon->getNameVern()
            ]);
        }

        return new JsonResponse($taxonList);
    }


    /**
     * @param Request $request
     * @param User $user
     * @return JsonResponse
     * @Route("/{id}/editUserAvatar", name="nao_edit_user_avatar")
     */
    public function imageCropperAction(Request $request, Observation $observation){
        $em = $this->getDoctrine()->getManager();

        if($data = $request->request->get('image')) {
            $user->getAvatar() ? $avatar = $user->getAvatar() : $avatar = new Avatar();

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'user-'.$user->getId().'.png';

            file_put_contents('uploads/avatar/'.$imageName, $data);

            $file = new UploadedFile('uploads/avatar/'. $imageName, $imageName,  'image/png');

            $avatar->setUser($user);
            $user->setAvatar($avatar);
            $avatar->setFile($file);
            $em->flush();

            return new JsonResponse("Avatar changed", 200);
        }
        return new JsonResponse("Avatar not changed", 500);
    }

    public function obsMarkerAction(Request $request)
    {
        $session = $request->getSession();
        $search = ($session->has('search')) ? $session->get('search') : new Search();

        $observations = $this
            ->getDoctrine()
            ->getManager()
            ->getRepository('ObservationBundle:Observation')
            ->SearchFiltered($search);
       
        $obsJson = [];
        foreach ($observations as $obs) {
            array_push($obsJson, [
                'id'        => $obs->getId(),
                'birdName'  => $obs->getBirdName(),
                'latitude'  => $obs->getLatitude(),
                'longitude' => $obs->getLongitude(),
                'url'       => $this->generateUrl('nao_obs_show', ['id' => $obs->getId()], UrlGeneratorInterface::ABSOLUTE_URL)
            ]);
        }
        return new JsonResponse($obsJson);
    }


    public function getUrlsTaxonAction($birdName)
    {
        $repository = $this->getDoctrine()->getManager()->getRepository('ObservationBundle:Taxon');
        $taxon = $repository->findByNameVern($birdName);

        if (is_null($taxon) or empty($birdName))
        {
            return new JsonResponse("null");
        }

        $urlsTaxon = [
            'urlInpn'   => $taxon->getUrlInpn(),
            'urlWiki'   => $taxon->getUrlWiki()
        ];

        return new JsonResponse($urlsTaxon);        
    }
}
