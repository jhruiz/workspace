
The install directory contains the djvulibre
and djview binary programs.
- To execute djview, use the desktop icon or the menu entry.
- To execute the other programs, add the djvulibre
  installation directory to the PATH variable 
  using the control panel, advanced tab,
  environment variables button.

This has been compiled using

- djvulibre-3.5.23
- djview-4.6
- Qt-4.4.0.

Compilation procedure.

- Install Microsoft Visual C++ 2008 Express Edition (MSVC9).
- Obtain djvulibre from cvs, install the jpeg, tiff and zlib sources
  in the respective subdirs of win32, and compile using the MSVC9 
  solution file win32/djvulibre/djvulibre.sln.
- Obtain the Qt/Win GPL sources, 
  run "configure -platform win32-msvc2005" 
  and compile using nmake
- Create a msvc project by running "qmake -tp vc" 
  in directory "djview/src"
- Start MSVC9, open the solution file "djvulibre.sln" and
  add the existing project "djview.vcproj" created by qmake.
- Open the project dependencies box and make the djview
  project dependent from libdjvulibre and libtiff.
- Open the property manager and add the existing
  property sheets "dirs.vsprops", "warnings.vsprops" and
  "tools.vsprops" found in the solution directory.
- Optionally open the properties box and review 
  the output directories. Otherwise djview.exe will be stored
  somewhere inside the djview source directory.
- Compile!

