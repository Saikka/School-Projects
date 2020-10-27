QT += qml quick widgets sql androidextras positioning location
CONFIG += c++11

DEFINES += QT_DEPRECATED_WARNINGS

ANDROID_PACKAGE_SOURCE_DIR = $$PWD/android-sources

SOURCES += \
        main.cpp \
    database.cpp \
    listmodel.cpp \
    dateclass.cpp \
    notificationclient.cpp \
    locationparser.cpp

RESOURCES += qml.qrc

OTHER_FILES += \
    qml/main.qml \
    android-sources/src/org/qtproject/example/notification/NotificationClient.java \
    android-sources/AndroidManifest.xml


qnx: target.path = $$[QT_INSTALL_EXAMPLES]/androidextras/notification
INSTALLS += target

HEADERS += \
    database.h \
    listmodel.h \
    dateclass.h \
    notificationclient.h \
    locationparser.h


#GEOLOCATION LIBRARY!!!
INCLUDEPATH += $$QT.location.includes

DISTFILES += \
    images/marker.png \
    images/meMark.png

contains(ANDROID_TARGET_ARCH,armeabi-v7a) {
    ANDROID_EXTRA_LIBS = \
        $$PWD/libcrypto.so \
        $$PWD/libssl.so
}
