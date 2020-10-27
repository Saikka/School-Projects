#include "locationparser.h"

#include <QObject>
#include <QGeoCodingManager>
#include <QGeoAddress>
#include <QGeoLocation>
#include <QGeoCoordinate>
#include <QGeoServiceProvider>
#include <QDebug>
#include <QGeoCodeReply>
#include <QApplication>
#include <QTimer>

LocationParser::LocationParser()
{
}

QString LocationParser::getCoordinates(QString address, QString city){



    QStringList qGeoSrvList = QGeoServiceProvider::availableServiceProviders();
    //Displaying all map providers
    for (auto v : qGeoSrvList){
        qDebug() << v;
    }
    //Going through all listed map providers
    for (QString entry : qGeoSrvList) {
        QGeoServiceProvider qGeoService(entry);
        QGeoCodingManager *pQGeoCoder = qGeoService.geocodingManager();
        if (!pQGeoCoder) {
            qDebug() << "USELESS PROVIDER";
            qDebug() << entry;
              continue;
         }
    qDebug() << "NICE PROVIDER";
    qDebug() << entry;

    QLocale qLocaleC(QLocale::C, QLocale::AnyCountry);
    pQGeoCoder->setLocale(qLocaleC);

    QString city = QString::fromUtf8( "Jyväskylä");
    QString address = QString::fromUtf8("Loukkukorventie 6c");
    QString country =  QString::fromUtf8("Finland");
    QString postalCode =  QString::fromUtf8("40640");

    QGeoAddress myAddress;
    myAddress.setCity(city);
    myAddress.setStreet(address);
    //myAddress.setPostalCode(postalCode);
    //myAddress.setCountry(country);
    QGeoLocation myGeoLocation;
    myGeoLocation.setAddress(myAddress);

    QGeoCoordinate myGeoCoordinate;

    QGeoCodeReply *pQGeoCode = pQGeoCoder->geocode(myAddress);

    if (!pQGeoCode) {
        qDebug() << ("Geocoding failed :D");
        continue;
    }

    qDebug() << ("Searching");
    //connect is called but finish never received...
    QObject::connect(pQGeoCode, &QGeoCodeReply::finished,
    [&myAddress, pQGeoCode](){
        qDebug () << ("Reply");
        qDebug() << pQGeoCode->errorString();
        switch (pQGeoCode->error()) {
            #define CASE(ERROR) \
            case QGeoCodeReply::ERROR:
                CASE(NoError);
                CASE(EngineNotSetError);
                CASE(CommunicationError);
                CASE(ParseError);
                CASE(UnsupportedOptionError);
                CASE(CombinationError);
                CASE(UnknownError);
            #undef CASE
                default: qDebug("UnknownError");
        }
        if (pQGeoCode->error() != QGeoCodeReply::NoError) return;
        QList<QGeoLocation> qGeoLocs = pQGeoCode ->locations();
        qDebug() << ("Size matters+-+-"+qGeoLocs.size());
        for (QGeoLocation &qGeoLoc : qGeoLocs){
            qGeoLoc.setAddress(myAddress);
            QGeoCoordinate myGeoCoordinate = qGeoLoc.coordinate();
            qDebug() << ("Moments before debug");
            qDebug()
                    << "Lat.: " << myGeoCoordinate.latitude() << endl
                    << "Long.: " << myGeoCoordinate.longitude() << endl
                    << "Alt.: " << myGeoCoordinate.altitude() << endl;

            qDebug() << ("myGeoCoordinate AFTER ");


        }
    });
    }

}
