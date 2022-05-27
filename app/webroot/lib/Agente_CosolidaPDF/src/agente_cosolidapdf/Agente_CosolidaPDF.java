/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package agente_cosolidapdf;

import Controller.ConsolidaPDF;

/**
 *
 * @author Walter Paz Londoño
 */
public class Agente_CosolidaPDF {

    /**
     * @param args the command line arguments
     */
    public static void main(String[] args) {
        // TODO code application logic here
        
        //Evalua si el parametro que se envia al ejecutable contiene valores
        if(args != null && args.length > 0){
            
            ConsolidaPDF consolidarPDF = ConsolidaPDF.getInstance();
            consolidarPDF.ContatenarPDF(args[0]);
            
        }
        
        
    }
    
}
