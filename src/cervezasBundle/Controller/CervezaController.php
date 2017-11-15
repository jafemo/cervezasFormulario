<?php

namespace cervezasBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use cervezasBundle\Entity\Cervezas;
use cervezasBundle\Form\CervezasType;
use Symfony\Component\HttpFoundation\Request;

//INSERTAR DEDE URL//
class CervezaController extends Controller{
    public function crearCervezaAction($nombre,$pais, $poblacion, $tipo){

      //Nuevo Objeto de tipo Cervezas
      $cerveza = new Cervezas();
      $cerveza->setNombre($nombre);
      $cerveza->setPais($pais);
      $cerveza->setPoblacion($poblacion);
      $cerveza->setTipo($tipo);
      $cerveza->setImportacion(true);
      $cerveza->setTamaño(20);
      $cerveza->setFechaAlmacen(\DateTime::createFromFormat("d/m/Y","24/12/2018"));
      $cerveza->setCantidad(20);
      $cerveza->setFoto('.png');

      //Doctrine
      $mangeDoct=$this->getDoctrine()->getManager();
      $mangeDoct->persist($cerveza);
      $mangeDoct->flush();
      return $this->render('cervezasBundle:Cervezas:crearCerveza.html.twig',array("cervezas"=>$cerveza));
    }


//INSERTAR//
    public function nuevoFormularioAction(Request $request){
      $cerveza = new Cervezas();
      $form= $this->createForm(CervezasType::class, $cerveza);
      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $cerveza = $form->getData();

        $em= $this->getDoctrine()->getManager();
        $em->persist($cerveza);
        $em->flush();

        return $this->redirectToRoute('cervezas_formulario');
      }
      return $this->render('cervezasBundle:Cervezas:index.html.twig', array("form"=>$form->createView() ));
    }

//ACTUALIZAR//
    public function actualizarCervezaAction(Request $request,$id)
    {
        $cerveza = $this->getDoctrine()->getRepository('cervezasBundle:Cervezas')->find($id);

        if(!$cerveza){return $this->redirectToRoute('cervezas_formulario');}
        $form = $this->createForm(\cervezasBundle\Form\CervezasType::class, $cerveza);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cerveza);
            $em->flush();
            return $this->redirectToRoute('cervezas_actualizar', ["id" => $id]);
        }
        return $this->render("cervezasBundle:Cervezas:formularioCervezas.html.twig", array('form'=>$form->createView() ));
    }


}
