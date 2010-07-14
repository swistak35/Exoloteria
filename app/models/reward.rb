class Reward < ActiveRecord::Base
	validates :name,	:presence => true
	validates :rate,	:presence => true
end
