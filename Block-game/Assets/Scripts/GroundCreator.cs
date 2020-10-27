using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.SceneManagement;

public class GroundCreator : MonoBehaviour {
    GameObject[] cubes;
    GameObject[] walls;

    int[] indexs;
    Color[] colors = new Color[9];
    Color[] colors2 = new Color[8];
    public Color mainColor;
    Color tempColor;

    public GameObject ground;
    public GameObject wallsObject;
    public GameObject mushroom;

    public GameObject menu;
    public GameObject mainCube;
    public Text levelText;
    public Text score;

    public GameObject gameOver;
    public GameObject startGame;

    public float timer;
    public int level = 1;
    public int blockNumber = 5;
    public int colorNumber = 5;

    bool start;

    void Awake()
    {
        gameOver.SetActive(false);
        menu.SetActive(false);
        start = true;
        ColorSet();
        mainColor = colors[Random.Range(0, 5)];
        tempColor = mainColor;
    }

    // Use this for initialization
    void Start () {
        //print(level);
        ColorPick();
        CreateGround(blockNumber, -4);
        CreateWalls(5, -4);
        ColorGround(blockNumber, 5, 3);
    }
	
	// Update is called once per frame
	void Update ()
    {
        if (start)
        {
            if (Input.GetKeyDown(KeyCode.Space))
            {
                startGame.SetActive(false);
                menu.SetActive(true);
                start = false;
            }
        }
        else CreateLevel(blockNumber, -4, colorNumber, 9);
               
     }


    //delay for restarting game
    public IEnumerator RestartGame()
    {
        yield return new WaitForSeconds(3f);
        SceneManager.LoadScene(0);
    }

    void CreateLevel(int lengthOfRow, int startingPosition, int amountOfMainColor, int amountOfColors)
    {
        timer += Time.deltaTime;
        if (timer >= 5.0f)
        {
            for (int i = 0; i < cubes.Length; i++)
            {
                if (cubes[i].GetComponent<Renderer>().material.color != mainColor) cubes[i].GetComponent<Rigidbody>().isKinematic = false;
            }
            for (int i = 0; i < walls.Length; i++)
            {
                Destroy(walls[i]);
            }
        }
        if (timer >= 9.0f)
        {
            if (mushroom.transform.position.y <= 0)
            {
                gameOver.SetActive(true);
                score.text = "You survived " + level + " levels";
                menu.SetActive(false);
                StartCoroutine(RestartGame());
            }
            else
            {
                for (int i = 0; i < cubes.Length; i++)
                {
                    Destroy(cubes[i]);
                }
                for (int i = 0; i < walls.Length; i++)
                {
                    Destroy(walls[i]);
                }
                level++;
                levelText.text = "Level: " + level;
                //mainColor = colors[Random.Range(0, amountOfColors)];
                MainColorPick(amountOfColors);
                ColorPick();
                CreateGround(lengthOfRow, startingPosition);
                CreateWalls(lengthOfRow, startingPosition);
                ColorGround(amountOfMainColor, lengthOfRow, amountOfColors);
                if (level <= 11)
                {
                    blockNumber = blockNumber + 2;
                    colorNumber = colorNumber + 5;
                }
                else if (level > 11 && colorNumber > 3)
                {
                    colorNumber = colorNumber - 5;
                }
            }
            timer = 0.0f;
        }
    }

    void CreateGround(int lengthOfRow, int startingPosition)
    {
        int size = lengthOfRow * lengthOfRow;
        GameObject prefab = Resources.Load("Cube") as GameObject;
        cubes = new GameObject[size];
        indexs = new int[size];
        MakeMassive(size, indexs);
        int startX = startingPosition;
        int startZ = startingPosition;
        int count = 0;
        for (int i = 0; i < lengthOfRow; i++)
        {
            for (int j = 0; j < lengthOfRow; j++)
            {
                cubes[count] = Instantiate(prefab) as GameObject;
                cubes[count].transform.parent = ground.transform;
                cubes[count].transform.position = new Vector3(startX, 0, startZ);
                startX = startX + 2;
                count++;
            }
            startZ = startZ + 2;
            startX = startingPosition;
        }
    }

    void CreateWalls(int lengthOfRow, int startingPosition)
    {
        int size = (lengthOfRow + 2) * 4 - 2;
        GameObject prefab = Resources.Load("Pillar") as GameObject;
        walls = new GameObject[size];
        int count = 0;
        int startX = startingPosition-2;
        int startZ = startingPosition-2;
        for (int i = 0; i < lengthOfRow + 2; i++)
        {
            walls[count] = Instantiate(prefab) as GameObject;
            walls[count].transform.parent = wallsObject.transform;
            walls[count].transform.position = new Vector3(startX, 0, startZ);
            startX = startX + 2;
            count++;
        }
        startZ = startZ + 2;
        startX = startX - 2;
        for (int i = 0; i < lengthOfRow + 1; i++)
        {
            walls[count] = Instantiate(prefab) as GameObject;
            walls[count].transform.parent = wallsObject.transform;
            walls[count].transform.position = new Vector3(startX, 0, startZ);
            startZ = startZ + 2;
            count++;
        }
        startX = startX - 2;
        startZ = startZ - 2;
        for (int i = 0; i < lengthOfRow + 1; i++)
        {
            walls[count] = Instantiate(prefab) as GameObject;
            walls[count].transform.parent = wallsObject.transform;
            walls[count].transform.position = new Vector3(startX, 0, startZ);
            startX = startX - 2;
            count++;
        }
        startZ = startZ - 2;
        startX = startX + 2;
        for (int i = 0; i < lengthOfRow; i++)
        {
            walls[count] = Instantiate(prefab) as GameObject;
            walls[count].transform.parent = wallsObject.transform;
            walls[count].transform.position = new Vector3(startX, 0, startZ);
            startZ = startZ - 2;
            count++;
        }
    }

    void ColorGround(int amountOfMainColor, int lengthOfRow, int amountOfColors)
    {
        int size = lengthOfRow * lengthOfRow;
        indexs = Shuffle(indexs);
        int[] indexs2 = new int[amountOfMainColor];
        for (int i=0; i<indexs2.Length; i++)
        {
            indexs2[i] = indexs[i];
        }
        for (int i = 0; i < size; i++)
        {
            bool isColored = false;
            for (int j = 0; j < indexs2.Length; j++)
            {
                if (i == indexs2[j])
                {
                    cubes[i].GetComponent<Renderer>().material.color = mainColor;
                    isColored = true;
                    break;
                }
            } 
            if (isColored == false) cubes[i].GetComponent<Renderer>().material.color = colors2[Random.Range(0, amountOfColors-1)];
        }

    }

    //makes massive with numbers from 0 to asked number
    void MakeMassive(int size, int[] array)
    {
        for (int i = 0; i < size; i++)
        {
            array[i] = i;
        }
    }

    //shuffles massive of numbers
    int[] Shuffle(int[] array)
    {
        for (int i = array.Length; i > 0; i--)
        {
            int j = Random.Range(0, i);
            int k = array[j];
            array[j] = array[i - 1];
            array[i - 1] = k;
        }
        return array;
    }

    //massive of colors for blocks
    void ColorSet()
    {
        colors[0] = Color.blue;
        colors[1] = Color.red;
        colors[2] = Color.green;
        colors[3] = Color.yellow;
        colors[4] = Color.black;
        colors[5] = Color.cyan;
        colors[6] = Color.magenta;
        colors[7] = Color.grey;
        colors[8] = Color.white;
    }

    //making massive without main color
    void ColorPick()
    {
        int count = 0;
        for (int i = 0; i < colors.Length; i++)
        {
            if (colors[i] != mainColor)
            {
                colors2[count] = colors[i];
                count++;
            }
        }
    }

    void MainColorPick(int amountOfColors)
    {
        mainColor = colors[Random.Range(0, amountOfColors)];
        while(true)
        {
            if (mainColor == tempColor)
            {
                mainColor = colors[Random.Range(0, amountOfColors)];
            }
            else
            {
                tempColor = mainColor;
                break;
            }
        }
    }
}
