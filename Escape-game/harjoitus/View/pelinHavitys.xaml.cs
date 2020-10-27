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
using System.Media;

namespace harjoitus.View
{  
    /// <summary>
    /// Interaction logic for pelinHavitys.xaml
    /// </summary>
    public partial class pelinHavitys : Window
    {
        SoundPlayer lose = new SoundPlayer(Properties.Resources.lose);
        SoundPlayer click = new System.Media.SoundPlayer(Properties.Resources.click);
        public pelinHavitys()
        {
            InitializeComponent();
            lose.Play();
        }

        private void btnExit_Click(object sender, RoutedEventArgs e)
        {
            click.Play();
            MainWindow game = new harjoitus.View.MainWindow();
            this.Close();
            game.ShowDialog();
        }
    }
}
