/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

package Controller;

import Controller.EntityConsolidaPDF;
import java.io.BufferedReader;
import java.io.FileNotFoundException;
import java.io.FileReader;
import java.io.IOException;
import java.io.PrintWriter;
import java.text.DateFormat;
import java.text.SimpleDateFormat;
import java.util.ArrayList;
import java.util.Date;
import java.util.List;

/**
 * @empresa Datecsa
 * @author Walter Paz Londoño
 * @fecha 06-feb-2017
 * @hora 16:29:26
 * --Descripción de funcionalidad
 */
public class LecturaPlano {
    private static LecturaPlano instance = null;
    private static String nombreArchivoLog = "";
    private static StringBuffer cadenaSalida;
    
    
    private LecturaPlano()
    {
        
    }
    
    
    public static LecturaPlano getInstance()
    {
        if(instance == null){
            instance = new LecturaPlano();
            cadenaSalida = new StringBuffer();
        }
        return instance;
    }
    
        
    /***
     * Se crea clase para realizar la lectura del archivo plano que contiene la siguiente estructura
        para la contatenacion de pdfs donde se tendra un archivo destino y los archivos pdf que se van a concatenar,
        a continuación se muestra la estructura del archivo plano

        RutaDestino:
        PDF:
        PDF:
        * 
     * @param paramRutaArchivoPlano (ruta donde se encuentra el archivo plano en disco)
     * @return la clase EntityConsolidaPDF si no ocurre un error en el proceso
     * @throws Exception 
     */    
    public EntityConsolidaPDF realizarLecturaPlano(String paramRutaArchivoPlano) throws Exception
    {
        try{
            
            BufferedReader in = new BufferedReader(new FileReader(paramRutaArchivoPlano));
            String line = ""; 
            
            EntityConsolidaPDF respuesta = null;
            List<String> listaTemporalPDF = null;
            
            while((line = in.readLine()) != null)
            {
                if(respuesta == null){
                    respuesta = new EntityConsolidaPDF();
                }
                
                if(line.contains("RutaDestino:"))
                {
                    line = line.replace("RutaDestino:", "");
                    respuesta.setRutaDestino(line);
                }
                
                if(line.contains("PDF:"))
                {
                    if(listaTemporalPDF == null){
                        listaTemporalPDF = new ArrayList<>();
                    }
                    line = line.replace("PDF:", "");
                    
                    listaTemporalPDF.add(line);
                }
                
                System.out.println(line);
            }
            //Cierra la lectura del archivo
            in.close();
            
            //Asigna la lista de pdf's leidos al archivo respuesta
            if(listaTemporalPDF != null && listaTemporalPDF.size() > 0){
                respuesta.setArchivosPDFConsolidar(listaTemporalPDF);
            }
            
            return respuesta;
        }
        catch(FileNotFoundException ex)
        {
            throw new Exception("No se cuenta con permisos para acceder al archivo "+ paramRutaArchivoPlano+ " -> " + ex.getMessage());
        }
        catch(IOException io)
        {
            throw new Exception("Ocurrio un error en la lectura del archivo plano" + paramRutaArchivoPlano + "->" + io.getMessage()) ;
        }
    }  
    
    
    public void EscribirLog(String paramEscribeLog)
    {
        try{
            Date fecha = new Date();
            DateFormat df = new SimpleDateFormat("yyyyMMdd");
            DateFormat dformatoHora = new SimpleDateFormat("HH:mm:ss");
            
            nombreArchivoLog = df.format(fecha);
            String horaActual = dformatoHora.format(fecha);
            
            nombreArchivoLog = "Archivolog_" + nombreArchivoLog + ".txt";

            //Se cambia la generación del archivo plano
            /*try (PrintWriter writer = new PrintWriter(nombreArchivoLog, "UTF-8")) {
                writer.println(horaActual + " -> nombreArchivo: " + nombreArchivoLog + " -> " + paramEscribeLog);
                writer.close();
            }*/
            String valorImprimir = horaActual + " -> nombreArchivo: " + nombreArchivoLog + " -> " + paramEscribeLog;
            cadenaSalida.append(valorImprimir);
            
            
        } catch (Exception e) {
           System.out.println("Error al generar al intentar escribir en el log --> " + e.getMessage());
        }
    }
    
    public String GenerarMensajes(){
        return cadenaSalida.toString();
    }
    
}
