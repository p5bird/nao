<?php
/**
 * Created by PhpStorm.
 * User: saiya
 * Date: 2/12/18
 * Time: 3:29 PM
 */

namespace BlogBundle\Controller;

use BlogBundle\Entity\Image;
use BlogBundle\Form\ArticleType;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use BlogBundle\Entity\Article;

class BlogController extends Controller {

    /**
     * @return Response
     * @Route("/blog/", name="nao_blog_index")
     */
    public function indexAction() {
        return $this->render('BlogBundle:Blog:index.html.twig');
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function addArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        if ($data = $request->request->get('image')) {
            $article->getImage() ? $image = $article->getImage() : $image = new Image();

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'article-' . $article->getUuid() . '.png';

            file_put_contents('uploads/blog/' . $imageName, $data);

            $file = new UploadedFile('uploads/blog/' . $imageName, $imageName, 'image/png');

            $image->setArticle($article);
            $article->setImage($image);
            $image->setFile($file);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('BlogBundle:Blog:addArticle.html.twig', array(
            'form' => $form->createView()
        ));
    }
}