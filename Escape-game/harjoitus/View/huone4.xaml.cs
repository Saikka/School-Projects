using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows;
using System.Windows.Controls;
using System.Windows.Data;
using System.Windows.Documents;
using System.Windows.Input;
using System.Windows.Media;
using System.Windows.Media.Imaging;
using System.Windows.Shapes;
using harjoitus.Model;
using System.Media;
using System.Windows.Threading;

namespace harjoitus.View
{
    /// <summary>
    /// Interaction logic for huone4.xaml
    /// </summary>
    public partial class huone4 : Window
    {
        Huone huone = new Huone();
        Avain avain1 = new Avain { KeyNumber = 1, IsFound = false };
        Avain avain2 = new Avain { KeyNumber = 2, IsFound = false };
        Avain avain3 = new Avain { KeyNumber = 3, IsFound = false };
        Esine tuoli1 = new Esine();
        Esine tuoli2 = new Esine();
        Esine olut1 = new Esine();
        Esine olut2 = new Esine();
        Esine pullo1 = new Esine();
        Esine pullo2 = new Esine();
        Esine pullo3 = new Esine();
        Esine pullo4 = new Esine();
        Esine pullo5 = new Esine();
        Esine pullo6 = new Esine();
        Esine pullo7 = new Esine();
        Esine pullo8 = new Esine();
        System.Windows.Threading.DispatcherTimer timer = new System.Windows.Threading.DispatcherTimer();
        int time = 0;

        public huone4()
        {
            InitializeComponent();
            IniMyStuff();
            TimerWork();
        }
        private void IniMyStuff()
        {
            huone = Toiminta.ReadFromFile();
            if (huone.IsSavedGame == false)
            {
                huone.RoomNumber = 4;
                Toiminta.NewGame(huone, avain1, avain2, avain3, message);
            }
            else
            {
                foreach (Avain a in huone.Avaimet)
                {
                    if (a.KeyNumber == 1)
                        avain1 = a;
                    else if (a.KeyNumber == 2)
                        avain2 = a;
                    else if (a.KeyNumber == 3)
                        avain3 = a;
                }
                Toiminta.LoadGame(huone, avain1, avain2, avain3, key1, key2, key3, menuKey1, menuKey2, menuKey3, message);
                time = 32 - huone.Time;
            }
        }

        #region Timer's work
        public void TimerWork()
        {
            timer = new DispatcherTimer();
            timer.Tick += new EventHandler(timer_Tick);
            timer.Interval = new TimeSpan(0, 0, 1);
            timer.Start();
        }

        private void timer_Tick(object sender, EventArgs e)
        {
            time++;
            huone.Time = Toiminta.Timer(timeshow, time);
            Toiminta.TimerWork(huone.Time, timeshow, this, timer);
        }

        public void TimerStart()
        {
            timer.Start();
        }

        #endregion

        #region Key's work
        private void OnButton1Click(object sender, RoutedEventArgs e)
        {
            avain1.KeyDisappear(huone, key1, menuKey1, menuKey2, menuKey3, message);
        }
        private void OnButton2Click(object sender, RoutedEventArgs e)
        {
            avain2.KeyDisappear(huone, key2, menuKey1, menuKey2, menuKey3, message);
        }
        private void OnButton3Click(object sender, RoutedEventArgs e)
        {
            avain3.KeyDisappear(huone, key3, menuKey1, menuKey2, menuKey3, message);
        }
        #endregion

        #region door's work
        private void OnDoor1Click(object sender, RoutedEventArgs e)
        {
            Toiminta.DoorWork(huone.KeyAmount, message, door1, door2, timer);
        }

        private void OnDoor2Click(object sender, RoutedEventArgs e)
        {
            SoundPlayer doorSound = new System.Media.SoundPlayer(Properties.Resources.door2);
            doorSound.Play();
            huone.IsSavedGame = false;
            Toiminta.Save(huone);
            huone5 h = new harjoitus.View.huone5();
            this.Close();
            h.ShowDialog();

        }
        #endregion

        #region furniture's work
        private void OnChair1Click(object sender, RoutedEventArgs e)
        {
            tuoli1.MoveLeft(chair1, 100);
        }
        private void OnChair2Click(object sender, RoutedEventArgs e)
        {
            tuoli2.MoveRight(chair2, 50);
        }
        private void OnBottle1Click(object sender, RoutedEventArgs e)
        {
            pullo1.MoveUpRight(bottle1, 30, 20);
        }
        private void OnBottle2Click(object sender, RoutedEventArgs e)
        {
            pullo2.MoveDownLeft(bottle2, 30, 30);
        }
        private void OnBottle3Click(object sender, RoutedEventArgs e)
        {
            pullo3.MoveUpRight(bottle3, 10, 10);
        }
        private void OnBottle4Click(object sender, RoutedEventArgs e)
        {
            pullo4.MoveDownLeft(bottle4, 10, 30);
        }
        private void OnBottle5Click(object sender, RoutedEventArgs e)
        {
            pullo5.MoveUpRight(bottle5, 10, 10);
        }
        private void OnBottle6Click(object sender, RoutedEventArgs e)
        {
            pullo6.MoveDownLeft(bottle6, 10, 25);
        }
        private void OnBottle7Click(object sender, RoutedEventArgs e)
        {
            pullo7.MoveRight(bottle7, 20);
        }
        private void OnBottle8Click(object sender, RoutedEventArgs e)
        {
            pullo8.MoveUpRight(bottle8, 30, 20);
        }
        private void OnBeer1Click(object sender, RoutedEventArgs e)
        {
            olut1.MoveRight(beer1, 50);
        }
        private void OnBeer2Click(object sender, RoutedEventArgs e)
        {
            olut2.MoveLeft(beer2, 40);
        }
        #endregion

        #region menu button's work

        private void exitButton_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.Exit(huone, this);
        }

        private void pauseButton_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.Save(huone);
            Toiminta.Pause(this, timer);
        }


        private void helpButton_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.HelpWork(avain1, avain2, avain3, hint1, hint2, hint3, message);
        }
        #endregion

        #region hint's work
        private void OnHint1Click(object sender, RoutedEventArgs e)
        {
            avain1.HintDisappear(hint1);
            if (olut1.IsMoved == false)
                olut1.MoveRight(beer1, 50);
            else
            {
                avain1.KeyDisappear(huone, key1, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint2Click(object sender, RoutedEventArgs e)
        {
            avain2.HintDisappear(hint2);
            if (pullo1.IsMoved == false)
            {
                pullo1.MoveUpRight(bottle1, 30, 20);
                if (pullo2.IsMoved == false)
                    pullo2.MoveDownLeft(bottle2, 30, 30);
            }
            else
            {
                avain2.KeyDisappear(huone, key2, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint3Click(object sender, RoutedEventArgs e)
        {
            avain3.HintDisappear(hint3);
            if (pullo3.IsMoved == false)
            {
                pullo3.MoveUpRight(bottle3, 10, 10);
                if (pullo4.IsMoved == false)
                    pullo4.MoveDownLeft(bottle4, 10, 30);
            }
            else
            {
                avain3.KeyDisappear(huone, key3, menuKey1, menuKey2, menuKey3, message);
            }
        }
        #endregion
    }
}