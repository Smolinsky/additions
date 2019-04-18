<?php
class ControllerReviewReviews extends Controller {
	public function index() {
		$this->load->language('review/reviews');

		$this->load->model('catalog/reviews');

		$this->load->model('tool/image');

		$data['breadcrumbs'] = array();

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_home'),
			'href' => $this->url->link('common/home')
		);

		$data['breadcrumbs'][] = array(
			'text' => $this->language->get('text_reviews'),
			'href' => $this->url->link('review/reviews')
		);

		$data['heading_title'] = $this->language->get('heading_title');
		$data['text_no_reviews'] = $this->language->get('text_no_reviews');

        $this->document->setTitle($data['heading_title']);

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['reviews'] = array();		

		$review_total = $this->model_catalog_reviews->getTotalReviewsByProductId();

		$results = $this->model_catalog_reviews->getReviews(($page - 1) * 10, 10);

		foreach ($results as $result) {
			$data['reviews'][] = array(
				'author'     => $result['author'],
                'image'     => $result['image'],
                'name'     => $result['name'],
                'rating'     => $result['rating'],
                'text'       => nl2br($result['text']),
                'date_added' => date($this->language->get('datetime_format'), strtotime($result['date_added'])),
                'href'        => $this->url->link('product/product', '&product_id=' . $result['product_id'])
			);
		}

		$pagination = new Pagination();
		$pagination->total = $review_total/2;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('review/reviews', '&page={page}');

		$data['pagination'] = $pagination->render();

			$data['continue'] = $this->url->link('common/home');

			$data['column_left'] = $this->load->controller('common/column_left');
			$data['column_right'] = $this->load->controller('common/column_right');
			$data['content_top'] = $this->load->controller('common/content_top');
			$data['content_bottom'] = $this->load->controller('common/content_bottom');
			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/review/reviews.tpl')) {
				$this->response->setOutput($this->load->view($this->config->get('config_template') . '/template/review/reviews.tpl', $data));
			} else {
				$this->response->setOutput($this->load->view('default/template/review/reviews.tpl', $data));
			}
		}
	}
