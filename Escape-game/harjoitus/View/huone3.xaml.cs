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
    /// Interaction logic for huone1.xaml
    /// </summary>
    public partial class huone3 : Window
    {
        Huone huone = new Huone();
        Avain avain1 = new Avain { KeyNumber = 1, IsFound = false };
        Avain avain2 = new Avain { KeyNumber = 2, IsFound = false };
        Avain avain3 = new Avain { KeyNumber = 3, IsFound = false };
        Esine tuoli1 = new Esine();
        Esine tuoli2 = new Esine();
        Esine tuoli3 = new Esine();
        Esine banana = new Esine();
        Esine lautanen1 = new Esine();
        Esine lautanen2 = new Esine();
        Esine lautanen3 = new Esine();
        Esine kuppi = new Esine();
        System.Windows.Threading.DispatcherTimer timer = new System.Windows.Threading.DispatcherTimer();
        int time = 0;

        public huone3()
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
                huone.RoomNumber = 3;
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
            huone4 h = new harjoitus.View.huone4();
            this.Close();
            h.ShowDialog();

        }
        #endregion

        #region furniture's work
        private void OnChair1Click(object sender, RoutedEventArgs e)
        {
            tuoli1.MoveDownLeft(chair1, 30, 30);
        }
        private void OnChair2Click(object sender, RoutedEventArgs e)
        {
            tuoli2.MoveLeft(chair2, 50);
        }
        private void OnChair3Click(object sender, RoutedEventArgs e)
        {
            tuoli3.MoveLeft(chair3, 100);
            avain1.MoveLeft(key1, 100);
        }
        private void OnBananClick(object sender, RoutedEventArgs e)
        {
            banana.MoveDown(banan, 30);
        }
        private void OnGlassClick(object sender, RoutedEventArgs e)
        {
            kuppi.MoveDownLeft(glass, 20, 20);
        }
        private void OnPlate1Click(object sender, RoutedEventArgs e)
        {
            lautanen1.MoveDownRight(plate1, 20, 40);
        }
        private void OnPlate2Click(object sender, RoutedEventArgs e)
        {
            lautanen2.MoveUpLeft(plate2, 20, 10);
        }
        private void OnPlate3Click(object sender, RoutedEventArgs e)
        {
            lautanen3.MoveUp(plate3, 10);
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
            if (tuoli3.IsMoved == false)
            {
                tuoli3.MoveLeft(chair3, 100);
                avain1.MoveLeft(key1, 100);
            }
            else
            {
                avain1.KeyDisappear(huone, key1, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint2Click(object sender, RoutedEventArgs e)
        {
            avain2.HintDisappear(hint2);
            if (lautanen1.IsMoved == false)
                lautanen1.MoveDownRight(plate1, 20, 40);
            else
            {
                avain2.KeyDisappear(huone, key2, menuKey1, menuKey2, menuKey3, message);
            }
        }
        private void OnHint3Click(object sender, RoutedEventArgs e)
        {
            avain3.HintDisappear(hint3);
            if (banana.IsMoved == false)
                banana.MoveDown(banan, 30);
            else
            {
                avain3.KeyDisappear(huone, key3, menuKey1, menuKey2, menuKey3, message);
            }
        }
        #endregion
    }
}