<?php
    namespace SONUser\Controller;

    use Zend\Mvc\Controller\AbstractActionController;
    use Zend\View\Model\ViewModel;

    use SONUser\Entity\User;

    class IndexController extends AbstractActionController {
        public function indexAction() {
            return new ViewModel();
        }

        public function createAction() {
            $request = $this->request;

            if ($request->isPost()) {
                try {
                    $data = array();

                    $user = new User();
                    $user->setNome($request->getPost('nome') ? $request->getPost('nome') : 'undefined')
                         ->setEmail($request->getPost('email') ? $request->getPost('email') : 'undefined@domain.com')
                         ->setPassword($request->getPost('password') ? $request->getPost('password') : '12345')
                         ->setActive($request->getPost('active'));

                    $em = $this->getServiceLocator()
                               ->get('Doctrine\ORM\EntityManager');
                    $em->persist($user);
                    $em->flush();

                    $data['reply'] = "{$user->getNome()}, foi adicionado com sucesso!";

                    return new ViewModel($data);
                }
                catch (Exception $e) {
                    echo $e->getTrace();
                }
            }
        }

        public function listAction() {
            $data = array();

            $em = $this->getServiceLocator()
                       ->get('Doctrine\ORM\EntityManager');
            $list = $em->getRepository('SONUser\Entity\User')
                       ->findAll();

            $data['list'] = $list;

            return new ViewModel($data);
        }

        public function editAction() {
            $data = array();

            $id = $this->params()
                       ->fromRoute('id');

            $em = $this->getServiceLocator()
                       ->get('Doctrine\ORM\EntityManager');

            $data['user'] = $em->find('SONUser\Entity\User', $id);

            $request = $this->getRequest();

            if ($request->isPost()) {
                try {
                    $data['user']->setNome($request->getPost('nome') ? $request->getPost('nome') : 'undefined')
                                 ->setEmail($request->getPost('email') ? $request->getPost('email') : 'undefined@domain.com')
                                 ->setPassword($request->getPost('password') ? $request->getPost('password') : '12345')
                                 ->setActive($request->getPost('active'))
                                 ->setUpdateAt();

                    $em->merge($data['user']);
                    $em->flush();
                }
                catch (Exception $e) {
                    echo $e->getTrace();
                }

                return $this->redirect()
                            ->toRoute('list-user');
            }

            return new ViewModel($data);
        }

        public function deleteAction() {
            $id = $this->params()
                       ->fromRoute('id');

            $em = $this->getServiceLocator()
                       ->get('Doctrine\ORM\EntityManager');

            $user = $em->find('SONUser\Entity\User', $id);

            $em->remove($user);
            $em->flush();

            return $this->redirect()
                        ->toRoute('list-user');
        }
    }
