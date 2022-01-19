const {
    Card,
    Alert,
    Button
}  = ReactBootstrap;
class Content extends React.Component {
    constructor(props) {
      super(props);
      this.state = {
        option : this.props.option,
        error: null,
        isLoaded: false,
        items: []
      };
    }
  
    componentDidMount() {
      fetch("http://localhost:8000/api/sujet/" + this.state.option)
        .then(res => res.json())
        .then(
          (result) => {
            this.setState({
              isLoaded: true,
              items: result
            });
          },
          // Remarque : il est important de traiter les erreurs ici
          // au lieu d'utiliser un bloc catch(), pour ne pas passer à la trappe
          // des exceptions provenant de réels bugs du composant.
          (error) => {
            this.setState({
              isLoaded: true,
              error
            });
          }
        )
    }
  
    render() {
      const { error, isLoaded, items } = this.state;
      if (error) {
        return <div>Erreur : {error.message}</div>;
      } else if (!isLoaded) {
        return <div>Chargement…</div>;
      } else {
        return (
          <div>
                <Card style={{}}>
                    <Card.Body>
                        <Card.Title>Card Title</Card.Title>
                        <Card.Text>
                            Some quick example text to build on the card title and make up the bulk of
                            the card's content.
                        </Card.Text>
                        <Button variant="primary">Go somewhere</Button>
                    </Card.Body>
                </Card>
          </div>
        );
      }
    }
  }


function App(){
    return (
        <React.Fragment>
            <Content option={document.querySelector('#root').dataset.option}/>
        </React.Fragment>
    );
}

ReactDOM.render(<App /> , document.querySelector('#root'));