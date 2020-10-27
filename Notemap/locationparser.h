#ifndef LOCATIONPARSER_H
#define LOCATIONPARSER_H

// standard C++ header:
#include <iostream>
#include <string>

#include <QObject>
#include <QGeoCodingManager>
#include <QGeoAddress>
#include <QGeoLocation>
#include <QGeoCoordinate>
#include <QGeoServiceProvider>

//Was an attempt to get coordinates from local geoaddress. Didnt work out.

class LocationParser : public QObject
{
    Q_OBJECT
public:
    LocationParser();
    //char address[]

public slots:
    QString getCoordinates(QString address, QString city);


};
#endif // LOCATIONPARSER_H
