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

namespace harjoitus.View
{
    /// <summary>
    /// Interaction logic for tauko.xaml
    /// </summary>
    public partial class tauko : Window
    {
        Huone huone = new Huone();
        SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
        SoundPlayer audio = new SoundPlayer(harjoitus.Properties.Resources.success);
        public tauko()
        {
            InitializeComponent();
            huone = Toiminta.ReadFromFile();
        }

        private void OnContinue_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.Continue(huone.RoomNumber, this);
        }

        private void OnSave_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            huone.IsSavedGame = true;
            Toiminta.Save(huone);
            audio.Play();
        }

        private void OnExit_Click(object sender, RoutedEventArgs e)
        {
            Toiminta.Save(huone);
            Toiminta.ExitPause(huone.RoomNumber, this);
        }
    }
}
