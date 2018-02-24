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
use BlogBundle\Form\CommentType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use BlogBundle\Entity\Article;
use BlogBundle\Entity\Comment;

class BlogController extends Controller {

    /**
     * @return Response
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();

        $lastThreeArticles = $em->getRepository('BlogBundle:Article')->getLastThreeArticles();

        return $this->render('BlogBundle:Blog:index.html.twig', array(
            'lastThreeArticles' => $lastThreeArticles
        ));
    }

    /**
     * Add an article
     *
     * @param Request $request
     * @return RedirectResponse|Response
     * @Security("has_role('ROLE_REDACTEUR')")
     */
    public function addArticleAction(Request $request) {
        $em = $this->getDoctrine()->getManager();

        $article = new Article();

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $article->setAuthor($this->getUser());

            $uniqueId = substr(md5(mt_rand()), 0, 7);
            $article->setUniqueId($uniqueId);
            $article->setSlug(mb_strtolower(str_replace("'", "-", str_replace(" ", "-", $this->container->get('app.replace_accented_char')->replace_accented_char($article->getTitle())))));

            if ($data = $request->request->get('base64File')['image']) {

                $article->getImage() ? $image = $article->getImage() : $image = new Image();

                list($type, $data) = explode(';', $data);
                list(, $data) = explode(',', $data);
                $data = str_replace('data:image/png;base64,', '', $data);
                $data = str_replace(' ', '+', $data);

                $data = base64_decode($data);

                $imageName = 'article-' . $article->getUniqueId() . '.png';

                file_put_contents('uploads/blog/' . $imageName, $data);

                $file = new UploadedFile('uploads/blog/' . $imageName, $imageName, 'image/png');

                $image->setArticle($article);
                $article->setImage($image);
                $image->setFile($file);
            }

            $em->persist($article);
            $em->flush();

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('BlogBundle:Blog:addArticle.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Show individual article
     *
     * @param Request $request
     * @param Article $article
     * @return RedirectResponse|Response
     */
    public function showArticleAction(Request $request, Article $article) {
        $em = $this->getDoctrine()->getManager();

        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $comment->setArticle($article);
        $comment->setAuthor($this->getUser());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();

            return $this->redirect($request->getUri());
        }

        return $this->render('BlogBundle:Blog:showArticle.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    /**
     * Delete an article
     *
     * @param $id
     * @return RedirectResponse
     * @Security("has_role('ROLE_REDACTEUR')")
     */
    public function deleteArticleAction($id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('BlogBundle:Article')->find($id);

        unlink('uploads/blog/article-' . $article->getUniqueId() . '.png');

        $em->remove($article);
        $em->flush();

        return $this->redirectToRoute('nao_blog_list_articles');
    }

    /**
     * Edit an article
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function editArticleAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $article = $em->getRepository('BlogBundle:Article')->find($id);

        $form = $this->createForm(ArticleType::class, $article);

        if ($data = $request->request->get('base64File')['image']) {

            $article->getImage() ? $image = $article->getImage() : $image = new Image();

            list($type, $data) = explode(';', $data);
            list(, $data) = explode(',', $data);
            $data = str_replace('data:image/png;base64,', '', $data);
            $data = str_replace(' ', '+', $data);

            $data = base64_decode($data);

            $imageName = 'article-' . $article->getUniqueId() . '.png';

            file_put_contents('uploads/blog/' . $imageName, $data);

            $file = new UploadedFile('uploads/blog/' . $imageName, $imageName, 'image/png');

            $image->setArticle($article);
            $article->setImage($image);
            $image->setFile($file);
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('nao_home');
        }

        return $this->render('BlogBundle:Blog:editArticle.html.twig', array(
            'article' => $article,
            'form' => $form->createView()
        ));
    }

    /**
     * List all articles
     *
     * @return Response
     * @Security("has_role('ROLE_REDACTEUR')")
     */
    public function listArticleAction() {
        $em = $this->getDoctrine()->getManager();
        $articles = $em->getRepository('BlogBundle:Article')->findAll();

        return $this->render('BlogBundle:Blog:listArticle.html.twig', array(
            'articles' => $articles
        ));
    }

    /**
     * List all comments
     *
     * @return Response
     */
    public function listCommentsAction() {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('BlogBundle:Comment')->findAll();

        return $this->render('BlogBundle:Blog:listComments.html.twig', array(
            'comments' => $comments
        ));
    }

    /**
     * Delete a comment
     *
     * @param $id
     * @return RedirectResponse
     */
    public function deleteCommentAction($id) {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('BlogBundle:Comment')->find($id);

        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('nao_blog_list_articles');
    }

    /**
     * Edit a comment
     *
     * @param Request $request
     * @param $id
     * @return RedirectResponse|Response
     */
    public function editCommentAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('BlogBundle:Comment')->find($id);

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->flush();

            return $this->redirectToRoute('nao_blog_list_comments');
        }

        return $this->render('BlogBundle:Blog:editComment.html.twig', array(
            'comment' => $comment,
            'form' => $form->createView()
        ));
    }
}